<template>
    <div class="container">
        <br/>
        <div class="row filter-bar">
            <div class="col-md-8">
                <ul class="filter-results">
                    <li class="filter-item">
                        <i class="fas fa-user-check"></i>
                        {{ products.length }} منتجات
                    </li>
                    <li class="filter-item">
                        <i class="fas fa-user-check"></i>
                        {{  finished_products  }} كل منتجات المنتهية
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <input type="text" placeholder="البحث فى المنتجات" v-model="search" class="form-control search-input"/>
            </div>
        </div>
        <div class="row">
            <ul class="content-page col-12">
                <li v-for="(product,key) in products" :key="key" class="col-md-3 item-product">
                    <div class="inner-product-item">
                        <span v-if="product.quantity == 0" style="color: red;position: absolute;font-weight: bold;">منتهى</span>
                        <img :src="product.thumbnail_item.image_url || ImageProd1" class="image-product">
                        <p>{{ product.name }}</p>
                        <p>
                            <strong>MRU {{ product.price }} </strong> /
                            <strong>الكمية {{ product.quantity }} </strong>
                        </p>
                        <router-link :to="{path:'/merchant/show-product/'+product.id}" class="btn btn-success btn-sm">تصفح المنتج </router-link>
                        <br/>
                    </div>
                </li>
            </ul>
            <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                <ul v-if="this.infos.total > products.length" class="pagination">
                    <li v-if="(this.infos.current_page != 1)" class="page-item">
                        <router-link class="page-link" :to="{path: '/merchant/products/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </router-link>
                    </li>
                    <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                        <template v-if="page == 1">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.current_page">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.current_page - 1">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.last_page">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>..</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/merchant/products/'+page}" active-class="active" exact>..</router-link>
                        </template>
                    </li>
                    <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                        <router-link :to="{path: '/merchant/products/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
        <div v-if="this.loading" style="position: fixed;top: 0px;bottom: 0px;background-color:#1d2024d1;left: 0;right: 0;z-index: 100000;text-align: center;">
            <img style="margin: 10% auto;" src="@/img/Enso-2.gif"/>
        </div>
    </div>
</template>
<script>
import marketerImage from '@/img/Circle-icons-profile.svg.png';
import ImageProd1 from '@/img/81g63eBEhxL._AC_UF894,1000_QL80_.jpg';
import ImageProd2 from '@/img/prod-2.png';
import ImageProd3 from '@/img/prod-3.png';
import ImageProd4 from '@/img/prod-4.png';
export default {
    components: {marketerImage,ImageProd1,ImageProd2,ImageProd3,ImageProd4},
    data(){
        return {
            ImageProd1,
            ImageProd2,
            ImageProd3,
            ImageProd4,
            marketerImage,
            active_products:0,
            finished_products:0,
            infos:[],
            marketer:{
                products:[]
            },
            products: [],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            field:{
                products:[]
            },
            loading:true
        }
    },
    methods:{
        FetchProducts:function(){
            let self = this;
            axios.get('/api/lowstock-products',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.products           = self.infos.data;
                self.finished_products  = data.finished_products;
                console.log(self.products);
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created:async function(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
        };
        await this.FetchProducts();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {q:search};
                axios.get('/api/products/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos              = [];
                    self.products          = data.data_info;
                    self.finished_products = data.finished_products;
                    self.active_products    = data.active_products;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
                };
                self.FetchProducts();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.marketers.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.marketers.forEach(function(item){
                    self.selected.splice(self.selected.indexOf(item.id),1);
                });
            }
        }
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
.item-product {
    padding: 20px;
    text-align: center;

    margin: 10px 0px;
    list-style: none;
    display: inline-block;
}
.inner-product-item{
    background-color: white;
    /*box-shadow: 10px 18px 16px 7px #e9e3e3;*/
    padding: 20px 10px 10px 10px;
    border: 1px solid #eee;
    position: relative;
}
.item-product img.image-product{
    width: 95%;
    max-height: 216px;
    min-height: 216px;
}
.item-product p
{
    padding: 10px 0px 0px 0px;
    font-size: 17px;
    margin-bottom: 0;
}
.content-page{
    display: inline-table;
}
.inner-product-item strong{
    line-height: 2.5em;
}
.inner-product-item button{
    border-radius:0px;
    margin:2px;
}
.inner-product-item .top-label{
    position: absolute;
    left: 0px;
    top: 0px;
    right: 0px;
    text-align: right;
}
.top-label input[type="checkbox"]{
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 50px;
    height: 22px;
}
.filter-bar .search-input{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
    margin-top: 34px;
}
.filter-bar .filter-results{
    list-style: none;
    padding: 0px
}
.filter-bar .filter-results .filter-item{
    padding: 10px 10px 10px 10px;
    display: inline-block;
    width: auto;
    background-color: #eee;
    margin: 0px 3px;
}
.filter-bar .search-input{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
    margin-top: 34px;
}
.page-item .page-link{
    margin: 9px 0px;
}
.page-item .page-link.active{
    background-color:black;
    color:white;
    border: 1px solid black;
    border-radius: 0px;
}
.page-item .page-link[aria-label='Previous'],
.page-item .page-link[aria-label='Next']
{
    border-radius: 0;
    background-color: orange;
    color: black;
    margin: 10px;
    border: 1px solid orange;
}
.filter-results .actions-btn{
   padding: 10px;
}
.filter-results .actions-btn button{
    margin: 2px;
}
.marketer-detailes{
    background-color: #f9fbe7;
    position: fixed;
    bottom: 0;
    z-index: 10000;
}
.banner-profile-marketer{
    padding: 10px;
    margin-bottom: 0px;
}
.marketer-detailes .banner-profile-marketer li
{
    list-style: none;
    display: inline-block;
}
.marketer-detailes .banner-profile-marketer li img{
    width:32px;
}
.label-name-marketer{
    padding:0px 20px;
    line-height: 2em;
    font-weight: bold;
}
.label-count-products{
    padding:0px 20px;
    font-weight: bold;
}
</style>
