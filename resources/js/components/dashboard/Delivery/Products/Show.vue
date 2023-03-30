<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="UpdateProduct">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-pallet" style="font-size: 18px;"></i>
                    عرض المنتج
                </h3>
            </div>
            <div class="row">
                <div class="col-lg-8 container-form-new-merchant">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    اسم المنتج
                                </label>
                                <p class="alert">{{ product.name }}</p>
                            </div>
                            <div class="form-group">
                                <label for="merchant-name">
                                    <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    سعر المنتج
                                </label>
                                <p class="alert">{{product.price}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="merchant-name">
                                    <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                                    عدد المنتجات
                                </label>
                                <p class="alert"> {{ product.quantity }}</p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="merchant-name">
                                    <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                                    وصف المنتج
                                </label>
                                <p>{{ product.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 container-form-new-merchant">
                    <ul class="attachments">
                        <li class="upload-product-image">
                            <img style="width:60%" :src="thumbnail_url" />
                            <p> صورة المنتج</p>
                        </li>
                        <li v-for="(attachment_url,key) in attachments_urls" :key="key" class="upload-attachments-image">
                            <img style="width:16%" :src="attachment_url" />
                            <label>  مرفقات المنتج رقم ( {{ key+1 }} )</label>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
        <div v-if="this.loading" style="position: fixed;top: 0px;bottom: 0px;background-color:#1d2024d1;left: 0;right: 0;z-index: 100000;text-align: center;">
            <img style="margin: 10% auto;" src="@/img/Enso-2.gif"/>
        </div>
    </div>
</template>
<script>
import ImageUploadHere from '@/img/upload-1118929_960_720.webp';
import AttachmentsUploadHere from '@/img/upload-1118929_960_720.webp';
export default {
    components: {ImageUploadHere,AttachmentsUploadHere},
    data(){
        return{
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
            loading:true
        }
    },
    methods:{
        FetchProduct:async function(){
            let self = this;
            let attachments;
            console.log(this.$route.params.id);
            await axios.get('/api/products/'+this.$route.params.id).then(function({data}) {
                // self.errors        = {};
                self.product       = data.product;
                self.thumbnail_url = data.product.thumbnail_item.image_url;
                attachments        = data.product.attachments_items.data;
                console.log(data);
            }).catch(function({response}) {
                self.errors = response.data;
            });

            if(attachments.length != 0 ){
                await attachments.forEach(function(attachment){
                    self.attachments_urls.push(attachment.image_url);
                    self.attachments_ids.push(attachment.id);
                    console.log(attachment,'nb');
                });
            }
        },
        UpdateProduct:function(){
            let self = this;
            let product = new FormData();
            product.append('name',this.product.name);
            product.append('description',this.product.description);
            product.append('price',this.product.price);
            product.append('quantity',this.product.quantity);
            product.append('status',this.product.status);


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
                self.success = data.result;
            }).catch(function({response}) {
                self.errors = response.data;
            });
        },
        UpdateDraftProduct:function(){
            this.field.status = 0;
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
    },
    mounted:function(){
        let self = this;
        setTimeout(() => {
            self.loading = false;
        }, 1000);
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
.container-form-new-merchant input[type='text']
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
.form-group .alert{
    font-weight: bold;
    margin: 0px;
    padding: 10px 32px;
    background-color: #eee;
    border-radius: 0px;
}
@media(max-width:1000px){
    .container-submit-btn-merchant button{
        margin: 1px;
        font-size: 12px;
    }
    .filter-bar .filter-results .filter-item{
        font-size: 11px;
        margin-bottom: 2px;
    }
}
</style>
