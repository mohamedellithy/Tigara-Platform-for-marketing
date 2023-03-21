<template>
    <div class="container">
        <br/>
        <div class="row filter-bar">
            <div class="col-md-8">
                <ul class="filter-results">
                    <li class="filter-item">
                        <i class="fas fa-users"></i>
                        {{ total_products }} منتجات
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
            <ul class="col-12 list-filter-items">
                <li class="list-filter-item">
                    <button @click="BrowseProduct(null)" :class="$route.query.filter == null ? 'active' : ''" >المنتجات</button>
                </li>
                <li class="list-filter-item">
                    <button @click="BrowseProduct('more-sales')" :class="$route.query.filter == 'more-sales' ? 'active' : ''" >الاكثر مبيعا</button>
                </li>
                <li class="list-filter-item">
                    <button @click="BrowseProduct('less-sales')" :class="$route.query.filter == 'less-sales' ? 'active' : ''" >الاقل مبيعا</button>
                </li>
                <li class="list-filter-item">
                    <button @click="BrowseProduct('high-price')" :class="$route.query.filter == 'high-price' ? 'active' : ''" >الاعلي سعرا</button>
                </li>
                <li class="list-filter-item">
                    <button @click="BrowseProduct('low-price')" :class="$route.query.filter == 'low-price' ? 'active' : ''"  >الاقل سعرا</button>
                </li>
                <li class="list-filter-item">
                    <button @click="BrowseProduct('low-stock')" :class="$route.query.filter == 'low-stock' ? 'active' : ''"  >المنتهية</button>
                </li>
                <br/><br/>

            </ul>
            <label>
                {{ products.length || 0 }} المعروض
            </label>
            <ul class="content-page row">
                <li v-for="(product,key) in products" :key="key" class="col-md-3 item-product">
                    <div class="inner-product-item">
                        <i class="fas fa-heart favourits-add"
                           @click="addToFavourit(product.id)"
                           :style="this.favourits.indexOf(product.id) != -1 ? 'color:#cb1515' : ''"></i>
                        <img :src="product.thumbnail_item.image_url || ImageProd1" class="image-product">
                        <router-link :to="{path:'/marketer/show-product/'+product.id}" style="text-decoration:none;">
                            <p>{{ product.name }}</p>
                        </router-link>
                        <table class="table product-info-details">
                            <tr>
                                <td>
                                    <strong>سعر المنتج</strong>
                                </td>
                                <td>
                                    <strong>USD {{ product.price }} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>الربح</strong>
                                </td>
                                <td>
                                    <strong>USD {{ product.marketer_profit || 0 }} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-info-quantity">
                                    <span class="fas fa-plus quantity-varite" @click="PlusQuantity(product)"></span>
                                    <label class="quantity-mini-cart">{{ this.orders[product.id] ? this.orders[product.id].quantity : 1  }}</label>
                                    <span class="fas fa-minus quantity-varite" @click="MinusQuantity(product)"></span>
                                </td>
                                <td>
                                    <span v-if="product.stock_quantity == 0" style="color: red;font-weight: bold;">منتهى</span>
                                    <span v-else> {{ product.stock_quantity }} قطعة</span>
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
            <nav v-if="this.infos" aria-label="Page navigation example">
                <ul v-if="this.infos.total > products.length" class="pagination">
                    <li v-if="(this.infos.current_page != 1)" class="page-item">
                        <router-link class="page-link" :to="{path: '/marketer/products/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1),query:$route.query }" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </router-link>
                    </li>
                    <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                        <template v-if="page == 1">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.current_page">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.current_page - 1">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="page == this.infos.last_page">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>{{ page }}</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>..</router-link>
                        </template>
                        <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                            <router-link class="page-link" :to="{path: '/marketer/products/'+page,query:$route.query}" active-class="active" exact>..</router-link>
                        </template>
                    </li>
                    <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                        <router-link :to="{path: '/marketer/products/'+(this.infos.current_page + 1),query:$route.query }" class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
        <div class="loading-overflow" v-show="showLoading">
            <img :src="loading" />
        </div>
    </div>
</template>
<script>
import marketerImage from '@/img/Circle-icons-profile.svg.png';
import loading from '@/img/loading.webp';
export default {
    components: {marketerImage,loading},
    data(){
        return {
            marketerImage,
            loading,
            active_products:0,
            finished_products:0,
            total_products:0,
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
            favourits:[],
            showsuccess:false,
            showerrors:false,
            success_message:'تم اضافة المنتج للسلة',
            error_message:'حدث خطأ اضافة المنتج للسلة',
            showLoading:false
        }
    },
    methods:{
        FetchProducts:function(){
            let self = this;
            axios.get('/api/marketer-products',{
                params:self.params
            }).then(function({data}){
                self.infos              = data.data_info;
                self.products           = self.infos.data;
                self.finished_products  = data.finished_products;
                self.active_products    = data.active_products;
                self.total_products     = data.total_products;
                self.favourits          = data.favourits;
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
            this.showLoading = true;
            await axios.post('/api/marketer-carts',this.orders[product.id]).then(function({data}){
                if(data.status){
                    self.showerrors = true;
                    self.error_message = data.status;
                }
                self.orders[product.id].quantity = 1;
                self.$emit('updateQuantity',data.total_quantity,data.cart_items);
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            }).then(function(){
                self.showsuccess = true;
                self.showLoading = false;
            });
        },
        BuyNow:async function(product){
            this.orders[product.id] = this.orders[product.id] || {};
            this.orders[product.id].product_id = product.id;
            this.orders[product.id].quantity   = (this.orders[product.id].quantity ? Number(this.orders[product.id].quantity) : 1);
            this.orders[product.id].price      = product.price;
            await this.AddtoCart(product);
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
        },
        addToFavourit:async function(product_id){
            let self = this;
            let field = {};
            field.product_id = product_id;
            this.showLoading = true;
            if(self.favourits.indexOf(product_id) == -1){
               await axios.post('/api/marketer-favourits',field).then(function({data}){
                   self.favourits.push(product_id);
                   console.log(data);
               }).catch(function({response}){
                   console.log(response);
               }).then(function(){
                    self.showsuccess = true;
                    self.showLoading = false;
                    self.success_message = 'تم اضافة المنتج للمفضلة';
                });
            } else {
                await axios.delete('/api/marketer-favourits/'+product_id).then(function({data}){
                   self.favourits.splice(self.favourits.indexOf(product_id),1);
                   console.log(data);
                }).catch(function({response}){
                   console.log(response);
                }).then(function(){
                    self.showsuccess = true;
                    self.showLoading = false;
                    self.success_message = 'تم حذف المنتج من المفضلة';
                });
            }
        },
        BrowseProduct:function(filter){
            let self = this;
            let filters = {};
            filters.filter = filter;
            this.$router.replace({
                query:filters
            });
        }
    },
    created:async function(){
        this.params.filter = this.$route.query.filter;
        this.params.page = this.$route.params.page_no ? this.$route.params.page_no : 1;
        await this.FetchProducts();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params.q = search;
                axios.get('/api/marketer-products/search',{
                    params:self.params
                }).then(function({data}){
                    self.infos              = [];
                    self.products          = data.data_info;
                    console.log(data);
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
    display: inline-flex;
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
.list-filter-item button
{
    padding: 9px 15px;
    color: black;
    border-radius: 33px;
    text-decoration: none;
    border: 0px;
    margin: 0px 8px;
}
.list-filter-item button.active{
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
.favourits-add{
    position: absolute;
    left: 6px;
    top: 9px;
    color: #afb4b8;
    font-size: 22px;
    font-weight: bold;
    cursor: pointer;
}
.loading-overflow{
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 1000000;
    width: 100% !important;
    text-align: center;
    padding-top: 12%;
    background-color: #06060647;
}
.loading-overflow img{
    width: 20% !important;
    margin: auto;

}
</style>
