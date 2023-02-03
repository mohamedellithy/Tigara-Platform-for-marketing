<template>
    <div v-if="ShowProducts" class="model-browose-products">
        <form method="post" @submit.prevent="AddProductsForCampaign">
            <div class="card card-model">
                <div class="top-header-model">
                    <p class="title-model">
                        تصفح المنتحات المتوفرة فى متجرك
                    </p>
                </div>
                <div class="body-of-model">
                    <table class="list-items">
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <input type="text" v-model="search"  placeholder="البحث فى المنتجات" class="form-control" />
                                </td>
                            </tr>
                            <template v-if="!search">
                                <tr v-for="(product,index) in products" :key="index">
                                    <td>
                                        <input type="checkbox" v-model="campaign.products" :value="product.id"/>
                                    </td>
                                    <td>
                                        <img :src="(product.image ? product.image : require('../../../../img/product.png'))"  class="product-img"/>
                                    </td>
                                    <td>
                                        <h6> {{ product.name }}</h6>
                                    </td>
                                    <td>
                                        <p>{{ product.formatted_price ? product.formatted_price : product.price }}</p>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr v-for="(product,index) in results" :key="index">
                                    <td>
                                        <input type="checkbox" v-model="campaign.products" :value="product.id"/>
                                    </td>
                                    <td>
                                        <img :src="(product.image ? product.image : require('../../../../img/product.png'))"  class="product-img"/>
                                    </td>
                                    <td>
                                        <h6> {{ product.name }}</h6>
                                    </td>
                                    <td>
                                        <p>{{ product.formatted_price ? product.formatted_price : product.price }}</p>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="top-footer-model">
                    <button type="submit" class="btn btn-primary">اضافة المهمة</button>
                    <button @click="CloseModel" type="button" class="btn btn-danger">الغاء</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        props:{
            ShowProducts:{
                default:false,
                type: Boolean
            },
            campaign:{
                default:{},
                type: Object
            }
        },
        data(){
            return{
                checked:null,
                search : '',
                products:[],
                results:{}
            }
        },
        methods:{
            CloseModel:function(){
                this.ShowEvents = false;
                this.$emit('modelshow', false);
            },
            AddProductsForCampaign:function(){
                this.CloseModel();
                this.$emit('updateFromProductsCampaign', this.campaign);
            }
        },
        watch:{
            search:function(search_value){
                this.results = this.products.filter(function(item){
                  let searc= item.name;
                  if(searc.search(new RegExp(search_value, "ig")) != -1){
                    return item;
                  }
                });
            }
        },
        created(){
            let self = this;
            axios.get('/api/zid-products').then(function({data}){
                self.products = data.products.results;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        }
    }
</script>
<style scoped>
   .model-browose-products{
        position: fixed;
        left:0%;
        right:0%;
        top:0%;
        bottom:0%;
        background-color:#00000047;
        text-align: center;
        overflow-y:auto;
        z-index: 100000;
   }
   .card-model{
        background-color:white;
        width:40%;
        height:auto;
        margin:auto;
        margin-top: 5%;
   }
   .title-model{
        padding: 9px 15px;
        text-align: right;
        font-size: 17px;
        line-height: 3em;
        border-bottom: 1px solid #eee;
   }
   .body-of-model{
        padding: 10px 20px;
        max-height:400px;
        overflow-y: auto;
   }
   .list-items{
     width:100%;
   }
   .list-items tr{
        padding: 14px;
   }
   .top-footer-model{
        text-align: left;
        padding: 10px;
        border-top:1px solid #eee;
   }
   .even-td
   {
        text-align: right;
   }
   td input[type="radio"]
   {
        float: right;
        margin-top: -40px;
        margin-right: 20px;

        height: 20px;
        width: 20px;
        vertical-align: middle;
   }
   .list-items tr{
        border-bottom: 1px solid #eee
   }
   .list-items tr:first-child {
        position: sticky;
        top: -14px;
        background: white;
    }
    .list-items tr td
   {
    padding: 5px;
   }
   .product-img{
       width: 50px;
   }
   @media(max-width:1000px){
        .card-model{
            width: 95%;
        }
        .product-img{
            width: 40px;
        }
    }
</style>
