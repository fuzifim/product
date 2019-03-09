<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Cache;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Redirect;
use DB;
class IndexController extends Controller
{
    public function __construct(){
    }
    public function index(Request $request){
        $page = $request->has('page') ? $request->query('page') : 1;
        $listProduct = Cache::store('memcached')->remember('listProduct_page_'.$page,1, function()
        {
            return DB::table('products')->where('status','active')->orderBy('updated_at','desc')->simplePaginate(20);
        });
        return view('index',array(
            'listProduct'=>$listProduct
        ));
    }
    public function viewProduct(Request $request){
        $id = $request->route('id');
        if(!empty($id)){
            $getProduct = Cache::store('memcached')->remember('product_'.$id,1, function() use($id)
            {
                return DB::table('products')->where('id',$id)
                    ->where('status','active')
                    ->first();
            });
            $listNew = Cache::store('memcached')->remember('listNew',1, function()
            {
                return DB::table('products')->where('status','active')->orderBy('updated_at','desc')->take(20)->get();
            });
            if(!empty($getProduct->title)){
                return view('viewProduct',array(
                    'product'=>$getProduct,
                    'listNew'=>$listNew
                ));
            }
        }
    }
    public function getProduct(){
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'text/html',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
                ],
                'connect_timeout' => '50',
                'timeout' => '50'
            ]);
            $getJob=DB::table('site_url')->where('status','active')->first();
            if(!empty($getJob->domain) && $getJob->page<=$getJob->limit_page){
                DB::table('site_url')
                    ->where('id', $getJob->id)
                    ->update(['page' => $getJob->page+1]);
                $response = $client->request('GET', 'https://api.accesstrade.vn/v1/datafeeds?domain='.$getJob->domain.'&page='.$getJob->page,
                    [
                        'headers' => [ 'Content-Type' => 'application/json','Authorization' => 'Token krkREE14smW4HEm9_7aGbcYHOCmFSdxs']
                    ]
                );
                $responseDecode=json_decode($response->getBody()->getContents());
                if($responseDecode->data>0){
                    foreach($responseDecode->data as $campaign){
                        $checkProduct=DB::table('products')
                            ->where('base_64',base64_encode($campaign->name))
                            ->where('domain',$getJob->domain)->first();
                        if(empty($checkProduct->title)){
                            if(!empty($campaign->cate)){
                                $category=str_replace('-', ' ', $campaign->cate);
                            }else{
                                $category='';
                            }
                            DB::table('products')->insert(
                                [
                                    'product_id' => $campaign->product_id,
                                    'title' => $campaign->name,
                                    'base_64'=>base64_encode($campaign->name),
                                    'description'=>$campaign->desc,
                                    'category'=>$category,
                                    'sku'=>$campaign->sku,
                                    'price'=>$campaign->price,
                                    'discount'=>$campaign->discount,
                                    'img_thumb'=>$campaign->image,
                                    'url'=>$campaign->url,
                                    'deeplink'=>$campaign->aff_link,
                                    'domain'=>$getJob->domain,
                                    'ads'=>'active',
                                    'status'=>'active',
                                    'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                                ]
                            );
                            echo $campaign->name.'<p>';
                        }
                    }
                }else{
                    DB::table('site_url')
                        ->where('id', $getJob->id)
                        ->update(['status' => 'disable']);
                }
            }
        }catch (\GuzzleHttp\Exception\ServerException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\BadResponseException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\ClientException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\ConnectException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\RequestException $e){
            return 'false';
        }
    }
    public function insertJob(){
        return view('insertJob',array());
    }
    public function insertJobSave(Request $request){
        $domain=$request->input('domain');
        $page=1;
        $client = new Client([
            'headers' => [
                'Content-Type' => 'text/html',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
            ],
            'connect_timeout' => '50',
            'timeout' => '50'
        ]);
        if(!empty($domain)){
            $response = $client->request('GET', 'https://api.accesstrade.vn/v1/datafeeds?domain='.$domain.'&page='.$page,
                [
                    'headers' => [ 'Content-Type' => 'application/json','Authorization' => 'Token krkREE14smW4HEm9_7aGbcYHOCmFSdxs']
                ]
            );
            $responseDecode=json_decode($response->getBody()->getContents(),true);
            if(is_array($responseDecode)){
                $checkJob=DB::table('site_url')->where('domain',$domain)->first();
                if(empty($checkJob->domain) && $responseDecode['total']>0){
                    $limitPage=(int)($responseDecode['total']/50);
                    DB::table('site_url')->insert([
                        [
                            'domain' => $domain,
                            'total' => $responseDecode['total'],
                            'per_page'=>50,
                            'page'=>1,
                            'limit_page'=>$limitPage,
                            'status'=>'active',
                            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                        ]
                    ]);
                    return back()->withErrors([
                        'message' => 'Thêm domain thành công!'
                    ]);
                }else{
                    return back()->withInput()->withErrors([
                        'message' => 'Domain này đã tồn tại!'
                    ]);
                }
            }
        }else{
            return back()->withInput()->withErrors([
                'message' => 'Không tìm thấy domain!'
            ]);
        }
    }
}