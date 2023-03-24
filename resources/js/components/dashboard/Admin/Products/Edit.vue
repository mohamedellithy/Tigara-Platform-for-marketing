<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="UpdateProduct">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-pallet" style="font-size: 18px;"></i>
                    تعديل المنتج
                </h3>

                <div class="col-md-4 container-submit-btn-merchant">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus"></i>
                        تعديل منتج مفعلا
                    </button>
                    <button type="button" @click="UpdateDraftProduct" value="0" class="btn btn-danger">
                        <i class="fas fa-user-slash"></i>
                         تعديل منتج غير مفعل
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 container-form-new-merchant">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                               <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                اسم المنتج
                            </label>
                            <input id="merchant-name" placeholder="اسم المنتج" class="form-control" type="text" v-model="product.name"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                سعر المنتج
                            </label>
                            <input id="merchant-name" placeholder="سعر المنتج" class="form-control" type="text" v-model="product.price"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                نوع المنتج
                            </label>
                            <ul class="private-products">
                                <li>
                                    <label>منتج عادى</label>
                                    <input type="radio" v-model="product.private" value="0"/>
                                </li>
                                <li>
                                    <label>منتج مميز</label>
                                    <input type="radio" v-model="product.private" value="1"/>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                تكلفة المنتج للتاجر ( USD )
                            </label>
                            <input id="merchant-name" placeholder="عمولة التاجر" class="form-control" type="text" v-model="product.merchant_commission"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                عمولة المسوق بالقيمة ( % )
                            </label>
                            <input id="merchant-name" placeholder="عمولة المسوق" class="form-control" type="text" v-model="product.marketer_commission"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user" style="padding: 5px;"></i>
                                اختيار التاجر
                            </label>
                            <select id="merchant-name" placeholder="اسم التاجر" class="form-control" type="text" v-model="product.merchant_id">
                                <option value="null">اختيار التاجر</option>
                                <option v-for="(merchant,index) in merchants" :value="merchant.id" :key="index">{{ merchant.name  }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                                عدد المنتجات
                            </label>
                            <input id="merchant-name" placeholder="عدد المنتجات" class="form-control" type="text" v-model="product.quantity"/>
                        </div>
                        <div class="form-group ">
                            <label for="merchant-name">
                                <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                                وصف المنتج
                            </label>
                            <textarea rows="10" cols="20" id="merchant-name" placeholder="وصف المنتج" class="form-control" type="text" v-model="product.description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 container-form-new-merchant">
                    <ul class="attachments">
                        <li class="upload-product-image">
                            <img style="width:60%" :src="thumbnail_url" />
                            <p> صورة المنتج</p>
                            <input @change="UploadThumbnail" type="file"/>
                        </li>
                        <li class="btn-upload-attachment">
                            <button  type="button" class="btn btn-primary btn-block">تحميل ملفات المنتج </button>
                            <input type="file" @change="UploadAttachments" multiple/>
                        </li>
                        <li v-if="attachments_urls.length == 0" class="upload-product-image">
                            <img style="width:60%" :src="AttachmentsUploadHere" />
                            <p>تحميل مرفقات المنتج</p>
                        </li>
                        <li v-for="(attachment_url,key) in attachments_urls" :key="key" class="upload-attachments-image">
                            <img style="width:16%" :src="attachment_url" />
                            <label>  مرفقات المنتج رقم ( {{ key+1 }} )</label>
                            <i @click="RemoveImagefromAttachment(key)" class="fas fa-times" style="color: red;float: left;cursor: pointer;margin-top: 5%;"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
    </div>
</template>
<script>
import ImageUploadHere from '@/img/upload-1118929_960_720.webp';
import AttachmentsUploadHere from '@/img/upload-1118929_960_720.webp';
export default {
    components: {ImageUploadHere,AttachmentsUploadHere},
    data(){
        return{
            merchants:[],
            product:{
                name:null,
                status:1,
                description:null,
                price:0.0,
                quantity:1,
                thumbnail:[],
                attachments:[]
            },
            errors:{},
            success:null,
            AttachmentsUploadHere,
            thumbnail_url:ImageUploadHere,
            attachments_urls:[],
            attachments_ids:[],
            delete_media_ids:[],
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر'
        }
    },
    methods:{
        FetchProduct:async function(){
            let self = this;
            let attachments;
            console.log(this.$route.params.id);
            await axios.get('/api/products/'+this.$route.params.id).then(function({data}) {
                self.errors        = {};
                self.product       = data.product;
                self.thumbnail_url = data.product.thumbnail_item.image_url;
                attachments        = data.product.attachments_items.data;
            }).catch(function({response}) {
                self.errors = response.data;
            }).then(function(){
                self.product.status = 1;
            });

            if(attachments.length != 0 ){
                await attachments.forEach(function(attachment){
                    self.attachments_urls.push(attachment.image_url);
                    self.attachments_ids.push(attachment.id);
                    console.log(attachment,'nb');
                });
            }
        },
        FetchMerchants:function(){
            let self =this;
            axios.get('/api/merchants').then(function({data}){
                self.infos              = data.data_info;
                self.merchants          = self.infos.data;
                console.log(self.merchants);
            }).catch(function({response}){ 
                console.log(response);
            });
        },
        UpdateProduct:function(){
            let self = this;
            let product = new FormData();
            product.append('name',this.product.name);
            product.append('description',this.product.description);
            product.append('price',this.product.price);
            product.append('quantity',this.product.quantity);
            product.append('status',this.product.status);
            product.append('private',this.product.private);
            product.append('merchant_id',this.product.merchant_id);
            product.append('merchant_commission',this.product.merchant_commission);
            product.append('marketer_commission',this.product.marketer_commission);
            if(this.product.thumbnail){
                product.append('thumbnail',this.product.thumbnail);
            }

            if(this.product.attachments){
                this.product.attachments.forEach(function(attachment,index){
                    product.append(`attachments[${index}]`,attachment);
                });
            }

            if(this.delete_media_ids.length != -1){
                Array.from(this.delete_media_ids).forEach(function(media_id,index){
                    product.append(`delete_media_ids[${index}]`,media_id);
                });
            }

            axios.post('/api/update-products/'+this.$route.params.id,product).then(function({data}) {
                self.errors  = {};
                self.showsuccess = true;
                self.success_message = data.result;
            }).catch(function({response}) {
                self.showerrors = true;
                self.errors = response.data;
            });
        },
        UpdateDraftProduct:function(){
            this.product.status = 0;
            this.UpdateProduct();
        },
        UploadThumbnail:function(thumbnail){
            this.product.thumbnail     = thumbnail.target.files[0];
            this.thumbnail_url = URL.createObjectURL(thumbnail.target.files[0]);
        },
        UploadAttachments:function(attachments){
            let self = this;
            let attachments_collections = attachments.target.files;
            self.product.attachments = [];
            Array.from(attachments_collections).forEach(function(attachment){
                self.attachments_urls.push(URL.createObjectURL(attachment));
                self.product.attachments.push(attachment);
            });
        },
        RemoveImagefromAttachment:function(index){
            this.delete_media_ids.push(this.attachments_ids[index]);
            
            if(this.product.attachments){
                this.product.attachments.splice(index,1);
            }

            this.attachments_urls.splice(index,1);
            this.attachments_ids.splice(index,1);
        }
    },
    created(){
        this.FetchProduct();
        this.FetchMerchants();
    }
}
</script>

<style scoped>
.container-body-merchant{
    padding: 4%;
}
.title-merchant{
    line-height:2.5em;
    color: #795548;
}
.container-form-new-merchant{
    /* padding: 0% 0% 0% 5%; */
    padding: 0% 0% 0% 1%;
}
.container-form-new-merchant .form-group label
{
    line-height: 3em;
    font-size: 17px;
}
.container-submit-btn-merchant{
    text-align: left;
}
.merchant-event-name{
    padding: 10px 23px;
    background-color: #cff0d0;
    font-weight: bold;
    position: relative;
    border: 1px solid #eee;
}
.change-event{
    position: absolute;
    left: 0;
    top: 0;
    padding: 10px;
    background-color: white;
    box-shadow: 0px 9px 15px 8px #d0d0d0;
    cursor: pointer;
}
.container-errors{
    padding: 20px 30px 0px 26px;
}
.container-errors .alert
{
    border-radius: 0px;
    box-shadow: 0px 0px 0px 0px #eee;
    border: none;
}

.container-submit-btn-merchant  button{
    margin: 5px;
}
.container-form-new-merchant .form-group{
    padding: 10px;
}
.container-form-new-merchant input[type='text'],
.container-form-new-merchant select
{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
}
.container-form-new-merchant textarea{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
}
.attachments{
    padding: 10px 10px;
}
.upload-product-image{
    text-align: center;
    list-style: none;
    text-align: center;
    list-style: none;
    padding: 15px;
    border: 5px dashed #eee;
    cursor: pointer;
    margin-bottom:20%;
    background: #fff;
}
.upload-product-image p
{
    padding: 15px;
    font-weight: bold;
}
.btn-upload-attachment{
     margin-bottom:5%;
     list-style: none;
     position:relative;
}
.upload-attachments-image{
    border: 1px solid #f4f2f2;
    list-style: none;
    background-color: white;
    padding: 12px;
}
.upload-attachments-image label{
    padding: 15px;
}
.btn-upload-attachment button{
    width: 100%;
}
.btn-upload-attachment input[type="file"]{
    position: absolute;
    left: 0px;
    top: 0px;
    right: 0px;
    opacity: 0;
    z-index: 1000;
    cursor: pointer;
}
.private-products{
    list-style: none;
    text-align: right;
    padding: 0px;
}
.private-products li{
    display: inline-block;
    padding: 0px 34px;
    direction: ltr;
}
.private-products li input[type="radio"]
{
    height: 19px;
    width: 26px;
    float: right;
    margin: 6px 2px;
}
.private-products li label
{
    line-height: 2.5em !important;
    font-size: 13px !important;
    font-weight: bold !important;
    color:#dc3545;
}
</style>
