<?php
namespace App\Services;

class Attachments {
    protected $Model;
    protected $attachment_type;
    public function __construct($model,$file,$attachment_type = 'thumbnail') {
        $this->Model = $model;

        $this->attachment_type = $attachment_type;
        
        if($attachment_type == 'thumbnail'):
        
            $this->insert_attachment($file,0);
        
        elseif ($attachment_type == 'attachments'):
        
            foreach ($file as $file_item):
        
                $this->insert_attachment($file_item,1);
        
            endforeach;
        
        endif;
    }

    public function insert_attachment($file,$image_type){
        
        $file_name = $file->getClientOriginalName();
        
        $file_extension = $file->getClientOriginalExtension();
        
        $tem_name = 'product_' . rand(1, 10000) . time() . '.' . $file_extension;
        
        $save_attachment = $file->storeAs('public/products',$tem_name);
        
        $this->Model->images()->create([
            'image_url' => 'products/'.$tem_name,
            'image_type'=> $image_type
        ]);
    }


}