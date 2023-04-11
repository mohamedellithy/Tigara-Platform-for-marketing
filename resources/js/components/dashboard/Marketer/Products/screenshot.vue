<template>
    <div class="container-body-merchant" >
        <form method="post" @submit.prevent="UpdateProduct">
            <div id="container-prod" class="row" style="border-bottom: 10px solid #ffc107;padding: 0px !important;margin:0px !important;height:auto;">
                <!-- <span style="border-radius: 37px;
                            position: absolute;
                            background-color: orange;
                            height: 75px;
                            left: 10px;
                            top: 10px;
                            z-index: 1000;
                            display: inline-block;
                            margin: auto;
                            right: auto;
                            width: 80px;
                            font-size: 36px;
                            font-weight: bolder;
                            padding: 7px 4px;">50%</span> -->
                <div class="col-lg-12 container-form-new-merchant" style="background-color: #0a2854;padding: 24px;position: relative;">
                    <h3 class="col-md-12 title-merchant" style="color:white;text-align: center;">
                        {{ product.name }}
                    </h3>
                    <ul class="attachments">
                        <li class="upload-product-image">
                            <img style="width:60%" :src="thumbnail_url" />
                        </li>
                        
                    </ul>
                    <ul style="text-align: center;">
                        <li v-for="(attachment_url,key) in attachments_urls" :key="key" class="upload-attachments-image">
                            <img  :src="attachment_url" />
                        </li>
                    </ul>
                    <br/>
                    <svg style="position: absolute;bottom: 0px;right: 0;left: 0px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                        <path fill="#eef5ff" fill-opacity="1"
                            d="M0,32L80,74.7C160,117,320,203,480,250.7C640,299,800,309,960,288C1120,267,1280,213,1360,186.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"
                            class="shape-fill"></path>
                    </svg>
                </div>
                <div class="col-lg-12 container-form-new-merchant" style="text-align: center;background-color: #eef5ff;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <span style="border-radius: 37px;
                            background-color: orange;
                            height: 75px;
                            display: inline-block;
                            margin: auto;
                            margin-bottom: 10px;
                            right: auto;
                            width: 80px;
                            font-size: 36px;
                            font-weight: bolder;
                            padding: 7px 4px;">
                            خصم <br/>
                            30%</span>
                            <h5 style="font-weight: Bolder;font-size: 25px;margin-top: 22px;">سعر المنتج {{product.price}}  أوقية جديدة فقط</h5>
                            </div>
                        </div>
                        <div class="col-lg-6" style="margin: auto;">
                            <div class="form-group">
                                <p style="font-size: 18px;font-weight: bold;" v-html="product.description"></p>
                            </div>
                            <button class="btn btn-warning" style="display: inline-block;margin: auto;margin-bottom: 45px;font-size: 18px;padding: 13px 62px;">
                                <p style="font-size: 27px;">للتواصل و طلب المنتج </p>
                                <p style="font-size: 22px;font-weight: bold;direction: ltr;">
                                    {{ marketer.phone }}
                                </p>
                            </button>
                        </div>
                    </div>
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
            product:{
                name:null,
                status:1,
                description:null,
                price:0.0,
                quantity:1,
                thumbnail:[],
                attachments:[],
                merchant:{}
            },
            errors:{},
            success:null,
            AttachmentsUploadHere,
            thumbnail_url:ImageUploadHere,
            attachments_urls:[],
            attachments_ids:[],
            delete_media_ids:[],
            marketer:{},
        }
    },
    methods:{
        FetchProduct:async function(){
            let self = this;
            let attachments;
            console.log(this.$route.params.id);
            await axios.get('/api/marketer-products/'+this.$route.params.id).then(function({data}) {
                self.errors        = {};
                self.product       = data.product;
                self.thumbnail_url = data.product.thumbnail_item.image_url;
                attachments        = data.product.attachments_items.data;
                console.log(self.product);
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
        },
        TakeScreenShoot:async function(){
            
            await axios.get('/api/take-screenshot-product/'+this.$route.params.id).then(function({data}){
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    async created(){
        let { data } = await axios.get('/api/me');
        this.marketer = data.user;
        this.FetchProduct();
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
    font-size: 25px;
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
    margin-bottom: 3px;
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
    list-style: none;
    padding: 12px;
    display: contents;
}
.upload-attachments-image img{
    width: 20%;
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
.container-body-merchant{
    background-color: white !important;
    padding: 0% 0%;
    overflow: hidden;
}
</style>
