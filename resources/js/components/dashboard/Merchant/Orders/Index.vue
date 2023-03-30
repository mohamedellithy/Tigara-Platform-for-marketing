<template>
    <div class="container">
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
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ all_orders }} الطلبات
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ process_orders }} جاري التنفيذ
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ wait_orders }} انتظار الموافقة
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ complete_orders }} المكتملة
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ refused_orders }} المرفوضة
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى الطلبات" v-model="search" class="form-control search-input"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label style="line-height: 3em;">فلترة الطلبات</label>
                            <select class="form-control filter-orders" v-model="order_filter">
                                <option value="all">الكل</option>
                                <option value="wait">الطلبات المنتظرة</option>
                                <option value="processing">الطلبات قيد التنفيذ</option>
                                <option value="completed">الطلبات المكتملة</option>
                                <option value="refused">الطلبات المرفوضة</option>
                                <option value="cancelled">الطلبات الملغية</option>
                            </select>
                        </div>
                        <br/>
                        <p style="padding: 20px 15px 0px 10px;" class="">
                            {{ orders.length }} طلبات
                        </p>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>صورة المنتج</th>
                                <th>المنتج</th>
                                <th>كمية الطلبية</th>
                                <th>سعر الوحدة</th>
                                <th>الخصم</th>
                                <th>سعر الطلبية</th>
                                <th>حالة الطلب</th>
                                <th>حالة الشحن</th>
                                <th>تاريخ الطلب</th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(order, key) in orders" :key="key">
                                <th scope="row"> # {{ order.order_id }}</th>
                                <th scope="row">
                                    <img style="width: 50px;height: 50px;" :src="order.product.thumbnail_item.image_url" />
                                </th>
                                <td>{{ order.product.name }}</td>
                                <td>{{ order.quantity }} قطعة</td>
                                <td>{{ order.product.merchant_commission || order.unit_price }} USD</td>
                                <td>{{ order.discount }}</td>
                                <td>{{ order.sub_total_original || order.sub_total }} USD</td>
                                <td>{{ order.order.order_status_txt }}</td>
                                <td>{{ order.order.shipping_status_txt }}</td>
                                <td>{{ order.created_at }}</td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > orders.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/merchant/orders/'+order_filter+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/merchant/orders/'+order_filter+'/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            all_orders:0,
            wait_orders:0,
            process_orders:0,
            complete_orders:0,
            refused_orders:0,
            order_filter:'all',
            infos:[],
            orders: [],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            field:{
                order_status:0,
                shipping_status:0,
                order_id:null,
                ids:[]
            }
        };
    },
    methods:{
        FetchOrders:function(){
            let self = this;
            axios.get('/api/orders',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos            = data.data_info;
                self.orders           = self.infos.data;
                self.all_orders       = data.all_orders;
                self.wait_orders      = data.wait_orders;
                self.process_orders   = data.process_orders;
                self.complete_orders  = data.complete_orders;
                self.refused_orders   = data.refused_orders;
                console.log(self.orders);
            }).catch(function({response}){
                console.log(response);
            });
        },
        ShowModelUpdateStatus:function(){
           this.showModel = true;
        },
        CloseModelUpdateStatus:function(){
            this.field = {
                order_status:0,
                shipping_status:0,
                order_id:null,
                ids:[]
            }
           this.showModel = false;
        },
        UpdateStatus:function(){
            let self = this;
            this.field.ids = this.selected;
            axios.put('/api/orders/update-status',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params = {
                    type:(self.$route.params.type ? self.$route.params.type : 'all'),
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                };
                self.FetchOrders();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
        },
        SingleStatus:function(order){
            let self = this;
            this.field.order_status = order.order_status;
            this.field.shipping_status = order.shipping_status;
            this.field.order_id = order.id;
            this.ShowModelUpdateStatus();
        },
        UpdateSingleStatus:function(order_id){
            let self = this;
            axios.put('/api/orders/'+order_id,this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params = {
                    type:(self.$route.params.type ? self.$route.params.type : 'all'),
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                };
                self.FetchOrders();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            });
        }
    },
    created:function(){
        this.params = {
            type:(this.$route.params.type ? this.$route.params.type : 'all'),
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
        };
        this.order_filter = (this.$route.params.type ? this.$route.params.type : 'all');
        this.FetchOrders();
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
                    type:(this.$route.params.type ? this.$route.params.type : 'all'),
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
                };
                self.FetchProducts();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.orders.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.orders.forEach(function(item){
                    self.selected.splice(self.selected.indexOf(item.id),1);
                });
            }
        },
        order_filter:function(filter){
           console.log(filter);
           this.$router.replace({
            params:{
                type:filter
            }
           });
        }
    }
};
</script>
<style scoped>
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
.filter-bar .filter-orders{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
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
@media(max-width:1000px){
    .container-submit-btn-merchant button{
        margin: 1px;
        font-size: 12px;
    }
    .filter-bar .filter-results .filter-item{
        font-size: 11px;
        margin-bottom: 2px;
    }
    .container-form-new-merchant{
        padding: 30px;
    }
}
</style>
