<template>
    <div class="container-body-merchant">
        <div class="row">
            <div class="col-lg-11 profile-image">
                <img :src="iconsProfile" />
                <p>
                    <template v-if="delivery.status == 0">
                        <i class="fas fa-circle" style="color:gray;"></i>
                    </template>
                    <template v-if="delivery.status == 1">
                        <i class="fas fa-circle" style="color:#2fc12f"></i>
                    </template>
                    {{ delivery.name }}
                </p>
                <p>
                    <router-link :to="{path:'/dashboard/show-delivery/'+delivery.id}" class="btn btn-warning btn-sm">
                        تفاصيل شركة الشحن
                        <i class="fas fa-eye"></i>
                    </router-link>
                </p>
            </div>
            <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>قيمة المبلغ</th>
                                <th>تفاصيل الطلبية</th>
                                <th>المبلغ المحصل</th>
                                <th>قيمة الطلبية</th>
                                <th>ربح المنصة</th>
                                <th>نوع المدفوعات</th>
                                <th>تاريخ الاضافة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(payment, key) in payments" :key="key">
                                <th scope="row">{{ payment.id }}</th>
                                <td>
                                    {{ payment.value }} USD
                                </td>
                                <td>
                                    <template v-if="payment.order_id">
                                        <router-link :to="{path:'/dashboard/show-order/'+payment.order_id}" style="text-decoration:none">
                                            رقم الطلبية # {{ payment.order_id }}
                                        </router-link>
                                    </template>
                                    <template v-else>
                                       -
                                    </template>
                                </td>
                                <td>
                                    <template v-if="payment.order_id">
                                        {{ payment.order.cash_delivered }} USD
                                    </template>
                                    <template v-else> - </template>
                                </td>
                                <td>
                                    <template v-if="payment.order_id">
                                        {{ payment.order.order_total }} USD
                                    </template>
                                    <template v-else> - </template>
                                </td>
                                <td>
                                    <template v-if="payment.order_id">
                                        {{ payment.order.platforms_profit_from_delivery_cash }} USD
                                    </template>
                                    <template v-else> - </template>
                                </td>
                                <td>{{ payment.type_text }}</td>
                                <td>{{ payment.created_at }}</td>
                                <td>
                                    <button v-if="!payment.order_id" @click="DeletePayment(payment.id)" class="btn btn-danger btn-sm" style="margin:0px 7px;">
                                        حذف
                                    </button>
                                    <button v-if="!payment.order_id" @click="ShowSingleUpdate(payment)" class="btn btn-info btn-sm" style="margin: 0px 7px;">
                                        تعديل
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > payments.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/show-payments-delivery/'+this.$route.params.id+'/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Modal -->
                <div v-show="this.showModel == true " id="exampleModalLive" class="modal fade " :class="[ this.showModel == true ? 'show' : '' ]" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" :style="`padding-right: 17px; display:block;padding-top: 10%;z-index: 100000;background: #0000001f;`">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">تحديث الحالة للتاجر</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="merchant-name">
                                    نوع المدفوعات
                                </label>
                                <select id="merchant-name" class="form-control" type="text" v-model="payment.type">
                                    <option value="0">اضافة مستحقات</option>
                                    <option value="1">تسديد مستحقات</option>
                                </select>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label for="merchant-name">
                                    المبلغ المطلوب اضافتة
                                </label>
                                <input id="merchant-name" placeholder="المبلغ" class="form-control" type="number" v-model="payment.value"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button @click="UpdateStatus()" type="button" class="btn btn-primary btn-sm" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
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
import iconsProfile from '@/img/shipping-delivery.png';
export default {
    components:{
        iconsProfile
    },
    data(){
        return{
            delivery:{},
            params:{
                q:null,
                delivery_id:null
            },
            payment:{},
            no_active_orders:0,
            active_orders:0,
            infos:[],
            payments: [],
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
            },
            iconsProfile,
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء المدفوعات بنجاح',
            error_message:'حدث خطأ اثناء حذف المدفوعات'
        }
    },
    methods:{
        FetchDelivery:function(){
            let self = this;
            console.log(this.$route.params.id);
            axios.get('/api/deliveries/'+this.$route.params.id).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.delivery = data.delivery;
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
            console.log(this.delivery);
        },
        FetchPayments:function(){
            let self = this;
            axios.get('/api/delivery-payments',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.payments          = self.infos.data;
                self.no_active_payment = data.no_active_payment;
                self.active_payment    = data.active_payment;
            }).catch(function({response}){
                console.log(response);
            });
        },
        DeletePayment:function(id){
            if(confirm(`تأكيد حذف المدفوعات رقم  ${ id }`)){
                let self = this;
                axios.delete('/api/delivery-payments/'+id).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.showsuccess = true;
                    self.success_message = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                        delivery_id:self.$route.params.id
                    };
                    self.FetchPayments();
                }).catch(function({response}){
                    console.log(response);
                    self.showerrors = false;
                    self.error_message = 'فشل حذف المدفوعات';
                });
            }
        },
        ShowSingleUpdate:function(payment){
           this.payment = payment;
           this.showModel = true;
        },
        CloseModelUpdateStatus:function(){
           this.showModel = false;
        },
        UpdateStatus:function(){
            let self = this;
            axios.put('/api/delivery-payments/'+this.payment.id,this.payment).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.showsuccess = true;
                self.success_message = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                    delivery_id:self.$route.params.id
                };
                self.FetchPayments();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = false;
                self.errors = response.data;
            })
        }
    },
    created(){
        this.FetchDelivery();
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
            delivery_id:this.$route.params.id
        };
        this.FetchPayments();
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
