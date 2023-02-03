<template>
    <div class="container-body-merchant">
        <div class="row">
            <div class="col-lg-11 profile-image">
                <img :src="iconsProfile" />
                <p>
                    <template v-if="merchant.status == 0">
                        <i class="fas fa-circle" style="color:gray;"></i>
                    </template>
                    <template v-if="merchant.status == 1">
                        <i class="fas fa-circle" style="color:#2fc12f"></i>
                    </template>
                    {{ merchant.name }}
                </p>
                <p>
                    <router-link :to="{path:'/dashboard/show-merchant/'+merchant.id}" class="btn btn-danger btn-sm">
                        تفاصيل التاجر
                        <i class="fas fa-eye"></i>
                    </router-link>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
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
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <button @click="DeleteSelectedProducts()" class="btn btn-primary btn-sm" :disabled="(selected.length == 0)">
                                        حذف المحدد
                                        <template v-if="selected.length != 0">
                                            ( {{ selected.length }} )
                                        </template>
                                    </button>
                                    <button @click="ShowModelUpdateStatus" class="btn btn-warning btn-sm" :disabled="(selected.length == 0)">
                                        تحديث الحالة
                                    </button>
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ products.length }} المنتجات
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ active_products }} مفعل
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ no_active_products }} غير مفعل
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى المنتجات" v-model="search" class="form-control search-input"/>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>
                                    <input class="" type="checkbox" v-model="selected_all"/>
                                </th>
                                <th>#</th>
                                <th>صورة المنتج</th>
                                <th>اسم المنتج</th>
                                <th>سعر المنتج</th>
                                <th>كمية المنتج</th>
                                <th>حالة المنتج</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(product, key) in products" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="product.id" :checked="selected.indexOf(product.id) != -1"/>
                                </th>
                                <th scope="row">{{ product.id }}</th>
                                <th scope="row">
                                    <img style="width: 70px;height: 50px;" :src="product.thumbnail_item.image_url" />
                                </th>
                                <td>{{ product.name }}</td>
                                <td>{{ product.price }} USD</td>
                                <td>{{ product.quantity }} منتج</td>
                                <td>{{ product.status_text }}</td>
                                <td class="actions-btn">
                                    <button @click="DeleteProduct(product.id,product.name)" class="btn btn-danger btn-sm">
                                        حذف
                                    </button>
                                     <router-link :to="{path:'/dashboard/show-product/'+product.id}"  class="btn btn-primary btn-sm">
                                        عرض
                                    </router-link>
                                    <router-link :to="{path:'/dashboard/edit-product/'+product.id}" class="btn btn-warning btn-sm">
                                        تعديل
                                    </router-link>

                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > products.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/show-products-merchant/'+this.$route.params.id+'/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div v-show="this.showModel == true " id="exampleModalLive" class="modal fade " :class="[ this.showModel == true ? 'show' : '' ]" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" :style="`padding-right: 17px; display:block;padding-top: 10%;z-index: 100000;background: #0000001f;`">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">تحديث الحالة المنتج</h5>
                        </div>
                        <div class="modal-body">
                            <p>الحالة</p>
                            <select type="text" class="form-control" v-model="field.update_status">
                                <option :value="0" selected>غير مفعل</option>
                                <option :value="1">مفعل</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button @click="UpdateStatus()" type="button" class="btn btn-primary" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import iconsProfile from '@/img/Circle-icons-profile.svg.png';
export default {
    components:{
        iconsProfile
    },
    data(){
        return{
            merchant:{},
            errors:{},
            success:null,
            iconsProfile,
            no_active_products:0,
            active_products:0,
            infos:[],
            products: [],
            search:null,
            params:{
                q:null,
                merchant_id:null
            },
            selected:[],
            selected_all:null,
            showModel:false,
            field:{
                update_status:0,
                ids:[]
            }
        }
    },
    methods:{
        FetchMerchant:function(){
            let self = this;
            console.log(this.$route.params.id);
            axios.get('/api/merchants/'+this.$route.params.id).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.merchant = data.merchant;
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
            console.log(this.merchant);
        },
        FetchProducts:function(){
            let self = this;
            axios.get('/api/products',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.products           = self.infos.data;
                self.no_active_products = data.no_active_products;
                self.active_products    = data.active_products;
                console.log(self.products);
            }).catch(function({response}){
                console.log(response);
            });
        },
        DeleteProduct:function(id,name){
            if(confirm(`تأكيد حذف المنتج ${ name }`)){
                let self = this;
                axios.delete('/api/products/'+id).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.success  = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                        merchant_id: self.$route.params.id
                    };
                    self.FetchProducts();
                }).catch(function({response}){
                    console.log(response);
                });
            }
        },
        DeleteSelectedProducts:function(){
            if(confirm(`تأكيد حذف المنتجات المحددة`)){
                let self = this;
                axios.delete('/api/products/delete-selected',{
                    params:{
                        type:'selected',
                        products:self.selected
                    }
                }).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.success  = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                        merchant_id: self.$route.params.id
                    };
                    self.FetchProducts();
                }).catch(function({response}){
                    console.log(response);
                });
            }
        },
        ShowModelUpdateStatus:function(){
           this.showModel = true;
        },
        CloseModelUpdateStatus:function(){
           this.showModel = false;
        },
        UpdateStatus:function(){
            let self = this;
            this.field.ids = this.selected;
            axios.put('/api/products/update-status',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                    merchant_id: self.$route.params.id
                };
                self.FetchProducts();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
        }
    },
    created(){
        this.FetchMerchant();
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
            merchant_id: this.$route.params.id
        };
        this.FetchProducts();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params.q = search;
                this.params.merchant_id = this.$route.params.id;
                axios.get('/api/products/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos                 = [];
                    self.products              = data.data_info;
                    self.no_active_products  = data.no_active_products;
                    self.active_products     = data.active_products;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
                    merchant_id: this.$route.params.id
                };
                self.FetchProducts();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.products.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.products.forEach(function(item){
                    self.selected.splice(self.selected.indexOf(item.id),1);
                });
            }
        }
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
    padding: 0% 0% 0% 5%;
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
    padding: 0px;
}
.container-form-new-merchant input[type='text'],
.container-form-new-merchant input[type='tel'],
.container-form-new-merchant input[type='email'],
.container-form-new-merchant input[type='password']
{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
}
.container-value-p{
    padding: 5px 30px;
    background-color: #e1dfdf94;
    line-height: 2.5em;
}
.show-products-merchants{
    float: left;
}
.container-body-merchant .profile-image img{
    width: 100px;
}
.container-body-merchant .profile-image
{
    text-align: center;
    padding: 10px;
}
.container-body-merchant .profile-image p
{
    padding: 11px 0px;
    margin-bottom: 0px;
}
.content-page {
    padding: 2%;
}
.actions-btn .btn{
    margin:1%;
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
</style>
