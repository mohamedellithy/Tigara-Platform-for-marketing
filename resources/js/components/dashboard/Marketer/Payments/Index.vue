<template>
    <div class="container-body-merchant">
        <div class="row">
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
                        <button @click="ShowModelPop" type="button" class="btn btn-primary btn-sm btn-block" style="margin:10px">
                            <i class="fas fa-plus"></i>
                            اضافة طلب سحب أرباح
                        </button><br/>
                        <ul class="filter-results">
                            <li class="filter-item">
                                <i class="fas fa-users"></i>
                                12344 اجمالى المبالغ 
                            </li>
                            <li class="filter-item">
                                <i class="fas fa-users"></i>
                                12344 اجمالى المبالغ الغير مسددة
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="البحث فى المدفوعات" v-model="search" class="form-control search-input"/>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <!--Table-->
                <table class="table">
                    <!--Table head-->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>المبلغ المطلوب</th>
                            <th>حالة الطلب</th>
                            <th>تاريخ الاضافة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <!--Table head-->
                    <!--Table body-->
                    <tbody>
                        <tr v-for="(payment, key) in payments" :key="key">
                            <th scope="row">#{{ payment.id }}</th>
                            <td>{{ payment.value }} USD</td>
                            <td>{{ payment.status_text }}</td>
                            <td>{{ payment.created_at }}</td>
                            <td class="action">
                                <button @click="CancelPayment(payment.id)" v-if="payment.payment_status == 0" class="btn btn-danger btn-sm">الغاء الطلب</button>
                                <button @click="EditPayment(payment)" v-if="payment.payment_status == 0" class="btn btn-warning btn-sm">تعديل الطلب</button>
                            </td>
                        </tr>
                    </tbody>
                    <!--Table body-->
                </table>
                <!--Table-->
                <nav v-if="this.infos" aria-label="Page navigation example">
                    <ul v-if="this.infos.total > payments.length" class="pagination">
                        <li v-if="(this.infos.current_page != 1)" class="page-item">
                            <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </router-link>
                        </li>
                        <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                            <template v-if="page == 1">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                            </template>
                            <template v-else-if="page == this.infos.current_page">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                            </template>
                            <template v-else-if="page == this.infos.current_page - 1">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                            </template>
                            <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                            </template>
                            <template v-else-if="page == this.infos.last_page">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                            </template>
                            <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                            </template>
                            <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                <router-link class="page-link" :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                            </template>
                        </li>
                        <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                            <router-link :to="{path: '/dashboard/show-payments-merchant/'+this.$route.params.id+'/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Modal -->
            <div class="overflow-model" v-if="showModel">
                <div class="content-overflow-model">
                    <div class="header-overflow-model">
                        <template v-if="field.id">
                            تعديل
                        </template>
                        طلب سحب من الارباح
                    </div>
                    <form method="post" @submit.prevent="AddNewPayments">
                        <div class="row body">
                            <div class="form-group">
                                <label class="label-input">قيمة المبلغ المطلوب للسحب</label>
                                <input v-model="field.value" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="footer-overflow-model">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <template v-if="!field.id">
                                    اضافة الطلب
                                </template>
                                <template v-if="field.id">
                                    تعديل الطلب
                                </template>
                            </button>
                            <button @click="ShowModelPop" type="button" class="btn btn-danger btn-sm">الغاء</button>
                        </div>
                    </form>
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
            params:{
                q:null,
                merchant_id:null
            },
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
                value:null,
                id:null
            },
            iconsProfile,
        }
    },
    methods:{
        FetchPayments:async function(){
            let self = this;
            await axios.get('/api/marketer-payments',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos             = data.data_info;
                self.payments          = self.infos.data;
                self.no_active_payment = data.no_active_payment;
                self.active_payment    = data.active_payment;
            }).catch(function({response}){
                console.log(response);
            });
        },
        ShowModelPop:function(){
            this.showModel = !this.showModel;
        },
        AddNewPayments:async function(){
            let self = this;
            if(self.field.id){
                await axios.put('/api/marketer-payments/'+self.field.id,self.field).then(function({data}){
                    console.log(data);
                    self.success = data.success;
                    self.FetchPayments();
                    self.ShowModelPop();
                }).catch(function({response}){
                    console.log(response);
                });
            } else {
                await axios.post('/api/marketer-payments',self.field).then(function({data}){
                    console.log(data);
                    self.success = data.success;
                    self.FetchPayments();
                    self.ShowModelPop();
                }).catch(function({response}){
                    console.log(response);
                });
            }
        },
        updatePayment:async function(payment_id,field){
            let self = this;
            await axios.put('/api/marketer-payments/'+payment_id,field).then(function({data}){
                console.log(data);
                self.FetchPayments();
            }).catch(function({response}){
                console.log(response);
            });
        },
        CancelPayment:async function(payment_id){
            let self = this;
            let field = {};
            field.payment_status = 3;
            if(confirm("تأكيد الغاء طلب المدفوعات ؟") == true){
                await self.updatePayment(payment_id,field);
            }
        },
        EditPayment:function(payment){
            this.field.value = payment.value;
            this.field.id    = payment.id;
            this.ShowModelPop();
        }
    },
    created(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
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
.overflow-model{
    position: fixed;
    background-color: #00000054;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: 100000;
}
.content-overflow-model{
    background-color:white;
    border-radius: 10px;
    width:50%;
    margin:auto;
    margin-top:8%;
}
.content-overflow-model label{
    padding: 10px;
    font-weight: 500;
}
.content-overflow-model button{
    margin: 5px;
}
.content-overflow-model .header-overflow-model{
    padding: 14px 18px 17px 3px;
    border-bottom: 1px solid #eee;
    font-weight: bold;
}
.content-overflow-model .footer-overflow-model{
    border-top: 1px solid #eee;
    font-weight: bold;
    padding: 14px;
}
.content-overflow-model .body
{
    padding: 22px;
}
table .action .btn{
    margin: 5px;
}
</style>
