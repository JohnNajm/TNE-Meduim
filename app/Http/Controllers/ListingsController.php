<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Http\Resources\ListingResource;

class ListingsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $listing = Listing::whereHas('category', function (Builder $query) {
            $query->where('accessibility', '=', 'public');
        })->where('visibility', '=', 'public')
        ->get();
        return $listing;
    }
    
    public function registeredindex()
    {
        
        $listing = Listing::all();
        return $listing;
    }
    
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {        
        $listing = listing::create([
            'title' => $request->title,
            'content' => $request->content,
            'visibility' => $request->visibility,
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            ]);
            
            
            $images = $request->file('images');
            if(!is_null($images)){
                if (count($images) >= 1 && count($images) <= 10){
                    foreach ($images as $image) {
                        $image->store('location'); 
                        
                        $insert = new Image();
                        $insert->filePath = $image;
                        $insert->listing_id = $listing->id;
                        $insert->save();
                    }
                    return ["result" => ["Success" => "Post Saved"]];
                } else {
                    return ["result" => ["Failed" => "You have attempted to upload more than 10 files!"]];
                }
            }
        }
        
        /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function show($id)
        {
            $listing = Listing::whereHas('category', function (Builder $query) {
                $query->where('accessibility', '=', 'public');
            })->where('visibility', '=', 'public')
            ->where('id', '=', $id)
            ->firstOrFail();
            return $listing;
        }
        
        public function registeredshow($id)
        {
            $listing = Listing::get()->where('id', '=', $id);
            return $listing;
            
        }
        
        /**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function edit($id)
        {
            //
        }
        
        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $id)
        {   
            $listing = Listing::where('id', '=', $id)->firstorfail();
            
            if(auth()->user()->id != $listing->user_id){
                return ["result" => ["Failed" => "Listing does not belong to you"]];
            }else{
                $listing->title = $request->title;
                $listing->content = $request->content;
                $listing->visibility = $request->visibility;
                $listing->category_id = $request->category_id;
                
                $result = $listing->save();
                
                if($result){
                    return ["result" => ["Success" => "Listing Updated"]]; 
                }else{
                    return ["result" => ["Failed" => "Operation failed, please try again later"]];   
                }
            }
        }
        
        public function hide($id){
            
            $listing = Listing::where('id', '=', $id)->firstorfail();
            $listing->visibility = 'hidden';
            $result = $listing->save();
            
            if($result){
                return ["result" => ["Success" => "Listing Updated"]]; 
            }else{
                return ["result" => ["Failed" => "Operation failed, please try again later"]];   
            }
            
            
            
            
            
        }
        /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id)
        {
            $listing = Listing::where('id', '=', $id)->firstorfail();
            
            if(auth()->user()->id != $listing->user_id){
                return ["result" => ["Failed" => "Listing does not belong to you"]];
            }else{
                $result = $listing->delete();
                
                if($result)
                {
                    return ["result" => ["Success" => "Listing Deleted"]];    
                }else{
                    return ["result" => ["Failed" => "Operation failed, please try again later"]];    
                }
                
            }
        }

        public function sudodestroy($id)
        {
            $listing = Listing::where('id', '=', $id)->firstorfail();
                $result = $listing->delete();
                if($result)
                {
                    return ["result" => ["Success" => "Listing Deleted"]];    
                }else{
                    return ["result" => ["Failed" => "Operation failed, please try again later"]];    
                }
                
            
        }

        public function sudoupdate(Request $request, $id)
        {   
            $listing = Listing::where('id', '=', $id)->firstorfail();
            
                $listing->title = $request->title;
                $listing->content = $request->content;
                $listing->visibility = $request->visibility;
                $listing->category_id = $request->category_id;
                
                $result = $listing->save();
                
                if($result){
                    return ["result" => ["Success" => "Listing Updated"]]; 
                }else{
                    return ["result" => ["Failed" => "Operation failed, please try again later"]];   
                }
            
        }
        

    }
    