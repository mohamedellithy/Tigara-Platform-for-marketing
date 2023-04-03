<template>
    <div class="container">
        <br/>
        <div class="row filter-bar">
            <div class="col-md-8">
                <ul class="filter-results">
                    <li class="filter-item">
                        <i class="fas fa-users"></i>
                        {{ products.length }} منتجات
                    </li>
                    <li class="filter-item">
                        <i class="fas fa-users"></i>
                        {{ active_products }} منتجات
                    </li>
                    <li class="filter-item">
                        <i class="fas fa-user-check"></i>
                        {{ finished_products }} منتجات منتهية
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <input type="text" placeholder="البحث فى المنتجات" v-model="search" class="form-control search-input"/>
            </div>
        </div>
        <div class="row">
            <ul class="content-page col-12">
                <li v-for="(product,key) in products" :key="key" class="col-md-3 col-12 item-product">
                    <div class="inner-product-item">
                        <img :src="product.thumbnail_item.image_url || ImageProd1" class="image-product">
                        <p>{{ product.name }}</p>
                        <table class="table product-info-details">
                            <tr>
                                <td>
                                    <strong>سعر المنتج</strong>
                                </td>
                                <td>
                                    <strong>MRU {{ product.price }} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>الربح</strong>
                                </td>
                                <td>
                                    <strong>MRU {{ product.marketer_profit }} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-info-quantity">
                                    <span class="fas fa-plus quantity-varite" @click="PlusQuantity(product)"></span>
                                    <label class="quantity-mini-cart">{{ this.orders[product.id] ? this.orders[product.id].quantity : 1  }}</label>
                                    <span class="fas fa-minus quantity-varite" @click="MinusQuantity(product)"></span>
                                </td>
                                <td>
                                    <span v-if="product.quantity == 0" style="color: red;font-weight: bold;">منتهى</span>
                                </td>
                            </tr>
                            <tr class="actions">
                                <td>
                                    <button class="btn btn-primary add-to-cart" @click="AddtoCart(product)">
                                        <i class="fas fa-shopping-cart"></i>
                                        اضافة الي السلة
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-info buy-now" @click="BuyNow(product)">
                                        <i class="fas fa-dolly-flatbed"></i>
                                        شراء الان
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>
            <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                <ul v-if="this.infos.total > products.length" class="pagination">
                    <li v-if="(this.infos.current_page != 1)" class="page-item">
                        <router-link class="page-link" :to="{path: '/marketer/favourits/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </router-link>
                    </li>
                    <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                        <template v-if="page == 1">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.current_page">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.current_page - 1">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.last_page">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>..</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/marketer/favourits/'+page}" active-class="active" exact>..</router-link>
                        </template>
                    </li>
                    <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                        <router-link :to="{path: '/marketer/favourits/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
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
            params:{
                q:null,
                page:null,
                filter_products:null
            },
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            field:{
                products:[]
            },
            filter_products:null,
            orders:[],
            loading:true
        }
    },
    methods:{
        FetchProducts:function(){
            let self = this;
            axios.get('/api/marketer-favourits',{
                params:self.params
            }).then(function({data}){
                self.infos              = data.data_info;
                self.products           = self.infos.data;
                self.finished_products  = data.finished_products;
                self.active_products    = data.active_products;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        },
        AddtoCart:async function(product){
            let self = this;
            this.orders[product.id] = this.orders[product.id] || {};
            this.orders[product.id].product_id = product.id;
            this.orders[product.id].quantity   = (this.orders[product.id].quantity ? Number(this.orders[product.id].quantity) : 1);
            this.orders[product.id].price      = product.price;
            await axios.post('/api/marketer-carts',this.orders[product.id]).then(function({data}){
                self.orders[product.id].quantity = 1;
                self.$emit('updateQuantity',data.total_quantity,data.cart_items);
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        },
        BuyNow:async function(product){
            this.orders[product.id] = this.orders[product.id] || {};
            this.orders[product.id].product_id = product.id;
            this.orders[product.id].quantity   = (this.orders[product.id].quantity ? Number(this.orders[product.id].quantity) : 1);
            this.orders[product.id].price      = product.price;
            await this.AddtoCart(product);
            console.log(product);
            this.$router.replace({
                path:'/marketer/carts'
            });
        },
        PlusQuantity:function(product){
            this.orders[product.id] = this.orders[product.id] || {};
            this.orders[product.id].product_id = product.id;
            this.orders[product.id].quantity   = (this.orders[product.id].quantity ? Number(this.orders[product.id].quantity) : 1) + 1;
            this.orders[product.id].price      = product.price;
            console.log(this.orders);
        },
        MinusQuantity:function(product){
            if(this.orders[product.id].quantity == 1){
                return;
            }
            this.orders[product.id] = this.orders[product.id] || {};
            this.orders[product.id].product_id = product.id;
            this.orders[product.id].quantity   = (this.orders[product.id].quantity ? Number(this.orders[product.id].quantity) : 1) - 1;
            this.orders[product.id].price      = product.price;
            console.log(this.orders);
        }
    },
    created:async function(){
        this.filter_products = window.localStorage.getItem('filter_products');
        this.params.filter_products = this.filter_products;
        this.params.page = this.$route.params.page_no ? this.$route.params.page_no : 1;
        await this.FetchProducts();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params.q = search;
                axios.get('/api/marketer-favourits/search',{
                    params:self.params
                }).then(function({data}){
                    self.infos              = [];
                    self.products          = data.data_info;
                    // self.finished_products = data.finished_products;
                    // self.active_products    = data.active_products;
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
        },
        filter_products:function(filter_products){
            let self =this;
            window.localStorage.setItem('filter_products',filter_products);
            this.params.filter_products = filter_products;
            if((filter_products.length != 0) && (filter_products != null)){
                axios.get('/api/products',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos              = data.data_info;
                    self.products           = self.infos.data;
                    self.finished_products = data.finished_products;
                    self.active_products    = data.active_products;
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                this.params.filter_products = null;
                self.params.page = (this.$route.params.page_no ? this.$route.params.page_no : 1)
                self.FetchProducts();
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
.filter-bar .search-input,select{
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
.product-info-details tr td:first-child{
    text-align: right;
}
.product-info-details tr td:last-child{
    text-align: left;
}
.product-info-details tr.actions .add-to-cart{
    color:white;
    background: #0d6efd;
    border:1px solid  #0d6efd;
    padding:5px 10px;
    border-radius: 30px;
    font-size: 12px;
}
.product-info-details tr.actions .buy-now{
    color:white;
    background: hsl(11deg 80% 45%);
    border:1px solid hsl(11deg 80% 45%);
    padding:5px 10px;
    border-radius: 30px;
    font-size: 12px;
}
.list-filter-items{
    list-style: none;
}
.list-filter-item{
    display: inline-block;
}
.list-filter-item a
{
    padding: 9px 15px;
    color: black;
    border-radius: 33px;
    text-decoration: none;
}
.list-filter-item a.active{
    background: #1b965d;
    color: white;
}
.product-info-details .quantity-mini-cart{

    background-color: #eee;
    padding: 3px 21px;
}
.product-info-details .product-info-quantity{
    padding: 10px 0px;
}
.product-info-details .product-info-quantity .quantity-varite{
    cursor: pointer;
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
