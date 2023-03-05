<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="CreateNewProduct" enctype="multipart/form-data">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-pallet" style="font-size: 18px;"></i>
                    اضافة منتج جديد
                </h3>

                <div class="col-md-4 container-submit-btn-merchant">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus"></i>
                        اضافة منتج مفعلا
                    </button>
                    <button type="button" @click="CreateNewDraftProduct" value="0" class="btn btn-danger">
                        <i class="fas fa-user-slash"></i>
                         اضافة منتج غير مفعل
                    </button>
                </div>
            </div>
            <div class="row">
                 <div v-if="Object.keys(this.errors).length !== 0" class="col-12 container-errors">
                    <div class="alert alert-danger">
                         <ul>
                            <li v-for="(error,index) in errors" :key="index"> {{ error[0] }}</li>
                         </ul>
                    </div>
                </div>
                <div v-if="this.success" class="col-12 container-errors">
                    <div class="alert alert-success">
                         <p>{{ success }}</p>
                    </div>
                </div>
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
                            <input id="merchant-name" placeholder="سعر المنتج" class="form-control" type="number" step="1.0" v-model="product.price"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                عمولة التاجر بالنسبة المئوية (%)
                            </label>
                            <input id="merchant-name" placeholder="عمولة التاجر" class="form-control" type="text" v-model="product.merchant_commission"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                عمولة المسوق بالقيمة ( USD )
                            </label>
                            <input id="merchant-name" placeholder="عمولة المسوق" class="form-control" type="text" v-model="product.marketer_commission"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant-name">
                                <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                                عدد المنتجات
                            </label>
                            <input id="merchant-name" placeholder="عدد المنتجات" class="form-control" type="number" v-model="product.quantity"/>
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
                        <div class="form-group">
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
    </div>
</template>
<script>
import ImageUploadHere from '@/img/upload-1118929_960_720.webp';
import AttachmentsUploadHere from '@/img/upload-1118929_960_720.webp';
export default {
    components: {ImageUploadHere,AttachmentsUploadHere},
    data(){
        return{
            merchant:{},
            merchants:null,
            product:{
                name:null,
                status:1,
                description:null,
                price:0.0,
                quantity:1,
                thumbnail:[],
                attachments:[],
                merchant_id:null
            },
            thumbnail_url:ImageUploadHere,
            attachments_urls:[],
            errors:{},
            success:null,
            AttachmentsUploadHere
        }
    },
    methods:{
        CreateNewProduct:function(){
            let self = this;
            let product = new FormData();
            product.append('name',this.product.name);
            product.append('description',this.product.description);
            product.append('price',this.product.price);
            product.append('quantity',this.product.quantity);
            product.append('status',this.product.status);
            product.append('thumbnail',this.product.thumbnail);
            product.append('merchant_id',this.product.merchant_id);
            product.append('merchant_commission',this.product.merchant_commission);
            product.append('marketer_commission',this.product.marketer_commission);
            this.product.attachments.forEach(function(attachment,index){
                product.append(`attachments[${index}]`,attachment);
            });
            console.log(product);
            axios.post('/api/products',product).then(function({data}) {
                console.log(data);
                self.errors  = {};
                self.success = data.result;
                self.product = {
                    status:1,
                };
                self.attachments_urls = [];
                self.thumbnail_url = ImageUploadHere;
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
            console.log(this.product);
        },
        CreateNewDraftProduct:function(){
            this.product.status = 0;
            this.CreateNewProduct();
        },
        UploadThumbnail:function(thumbnail){
            console.log(URL.createObjectURL(thumbnail.target.files[0]));
            this.product.thumbnail     = thumbnail.target.files[0];
            this.thumbnail_url = URL.createObjectURL(thumbnail.target.files[0]);
        },
        UploadAttachments:function(attachments){
            let self = this;
            let attachments_collections = attachments.target.files;
            Array.from(attachments_collections).forEach(function(attachment){
                self.attachments_urls.push(URL.createObjectURL(attachment));
                self.product.attachments.push(attachment);
                console.log(attachment);
            });
        },
        RemoveImagefromAttachment:function(index){
            this.product.attachments.splice(index,1);
            this.attachments_urls.splice(index,1);
            console.log(this.product.attachments);
        }
    },
    created(){
        let self = this;
        axios.get('/api/merchants').then(function({data}){
            self.infos              = data.data_info;
            self.merchants          = self.infos.data;
            console.log(self.merchants);
        }).catch(function({response}){ 
            console.log(response);
        });
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
.container-form-new-merchant input[type='number'],
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
     position: relative;
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
</style>
