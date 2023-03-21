<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <button v-if="this.$route.params.type != 'complete'" @click="ShowModelUpdateStatus" class="btn btn-warning btn-sm" :disabled="(selected.length == 0)">
                                        تحديث الحالة
                                    </button>
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ orders_count }} الطلبات
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى الطلبات" v-model="search" class="form-control search-input"/>
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
                                <th>رقم الطلب</th>
                                <th>كمية الطلبية</th>
                                <th>سعر الطلبية</th>
                                <th>المبلغ المحصل</th>
                                <th>المبلغ المرتجع</th>
                                <th>حالة الطلب</th>
                                <th>حالة الشحن</th>
                                <th>تاريخ الطلب</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(order, key) in orders" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="order.id" :checked="selected.indexOf(order.id) != -1"/>
                                </th>
                                <th scope="row"> # {{ order.id }}</th>
                                <td>{{ order.quantity }} قطعة</td>
                                <td>{{ order.order_total }} USD</td>
                                <td>{{ order.cash_delivered > 0 ? order.cash_delivered + 'USD' : 'لم يتم تحصيل' }} </td>
                                <td>{{ order.cash_delivery_refund ? order.cash_delivery_refund  + 'USD' : 'لايوجد'  }} </td>
                                <td>{{ order.order_status_txt }}</td>
                                <td>{{ order.shipping_status_txt }}</td>
                                <td>{{ order.created_at }}</td>
                                <td class="actions-btn">
                                    <router-link :to="{path:'/delivery/delivery-show-orders/'+order.id}"  class="btn btn-primary btn-sm">
                                        عرض
                                    </router-link>
                                    <!-- v-if="this.$route.params.type != 'complete'" -->
                                    <button  @click="SingleStatus(order)" class="btn btn-warning btn-sm">
                                        تحديث الحالة
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > orders.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/delivery/delivery-wait-orders/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/delivery/delivery-wait-orders/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
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
                            <h5 class="modal-title" id="exampleModalLiveLabel">
                                تحديث حالة الطلب
                                <template v-if="field.order_id != null">
                                    # {{ field.order_id }}
                                </template>
                            </h5>
                        </div>
                        <div class="modal-body">
                            <p>حالة الشحن</p>
                            <select type="text" class="form-control" v-model="field.shipping_status">
                                <option :value="0" selected>بانتظار الموافقة</option>
                                <option :value="1">جاري التنفيذ</option>
                                <option :value="2" v-if="field.order_id">مكتملة</option>
                                <option :value="3">مرفوضة</option>
                                <option :value="4">مرتجع</option>
                            </select>
                        </div>
                        <div class="modal-body" v-if="field.shipping_status == 2">
                            <p>المبلغ الذى تم تحصيلة من الزبون</p>
                            <input type="text" class="form-control" v-model="field.cash_delivered"/>
                        </div>
                        <div class="modal-body" v-if="field.shipping_status == 4">
                            <p>المبلغ الذى تم استرجاعة للزبون</p>
                            <input type="text" class="form-control" v-model="field.cash_delivery_refund"/>
                        </div>
                        <div class="modal-body">
                            <p>ملاحظات</p>
                            <textarea type="text" class="form-control" v-model="field.delivery_notice"></textarea>
                        </div>
                        <div class="modal-footer">
                            <template v-if="field.order_id == null">
                                <button @click="UpdateStatus()" type="button" class="btn btn-primary btn-sm" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            </template>
                            <template v-if="field.order_id != null">
                                <button @click="UpdateSingleStatus(field.order_id)" type="button" class="btn btn-primary btn-sm" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            </template>
                            <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
    </div>
</template>
<script>
import AlertResponse from '../../../AlertResponse.vue';
export default {
    data() {
        return {
            orders_count:0,
            infos:[],
            orders: [],
            search:null,
            types_orders:{
                dairy:0,
                wait:1,
                process:2,
                complete:3,
                cancelled:4,
                return:5,

            },
            params:{
                q:null,
                page:null,
                type:1
            },
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
            },
            showsuccess:false,
            showerrors:false,
            success_message:'تم تحديث الطلب بنجاح',
            error_message:'حدث خطأ اثناء تحديث الخطأ'
        };
    },
    methods:{
        FetchOrders:async function(){
            let self = this;
            await axios.get('/api/orders',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos            = data.data_info;
                self.orders           = self.infos.data;
                self.orders_count     = data.orders_count;
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
        UpdateStatus:async function(){
            let self = this;
            this.field.ids = this.selected;
            await axios.put('/api/orders/update-status',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params.page = (self.$route.params.page_no ? self.$route.params.page_no : 1);
                self.params.type = self.types_orders[self.$route.params.type];
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
            this.field.cash_delivered = order.cash_delivered;
            this.field.cash_delivery_refund = order.cash_delivery_refund;
            this.field.delivery_notice = order.delivery_notice;
            this.field.order_id = order.id;
            this.ShowModelUpdateStatus();
        },
        UpdateSingleStatus:async function(order_id){
            let self = this;
            await axios.put('/api/orders/'+order_id,this.field).then(function({data}) {
                console.log(data);
                self.success_message = data.result;
                self.showsuccess = true;
                self.params.page = (self.$route.params.page_no ? self.$route.params.page_no : 1);
                self.params.type = self.types_orders[self.$route.params.type];
                self.FetchOrders();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data.errors;
            });
        }
    },
    created:function(){
        this.params.page = (this.$route.params.page_no ? this.$route.params.page_no : 1);
        this.params.type = this.types_orders[this.$route.params.type] || 0;
        this.FetchOrders();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params.q = search;
                axios.get('/api/orders/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos                  = [];
                    self.orders                 = data.data_info;
                    self.orders_count           = data.orders_count;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params.page = (this.$route.params.page_no ? this.$route.params.page_no : 1);
                self.params.type = this.types_orders[this.$route.params.type] || 0;
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
