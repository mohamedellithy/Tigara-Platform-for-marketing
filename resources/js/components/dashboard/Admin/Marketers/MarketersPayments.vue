<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <button @click="ShowModelUpdateStatus" class="btn btn-warning btn-sm"  :disabled="(selected.length == 0)">
                                        تحديث الحالة
                                    </button>
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ active_marketers }} MRU مسوقين
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ payments_make }} MRU مسددة
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ payments_due }} MRU غير مسددة
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ profits }} MRU الارباح
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ pending_profits }} MRU المحظور
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
                                <th>
                                    <input class="" type="checkbox" v-model="selected_all"/>
                                </th>
                                <th>اسم المسوق</th>
                                <!-- <th>المدفوعات المستحقة</th>
                                <th>اجمالى المدفوعات</th> -->
                                <th>المحظور</th>
                                <th>المسموح السحب</th>
                                <th>المبلغ المطلوب </th>
                                <th>ملاحظات الدفع</th>
                                <th>حالة الطلب</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(payment, key) in payments" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="payment.id" :checked="selected.indexOf(payment.id) != -1"/>
                                </th>
                                <td>{{ payment.marketer.name }}</td>
                                <!-- <td>{{ payment.marketer.total_profites }} MRU</td>
                                <td>{{ payment.marketer.total_paid  }} MRU</td> -->
                                <td>{{ payment.marketer.total_profit_pending }} MRU</td>
                                <td>{{ payment.marketer.total_un_paid - payment.marketer.total_profit_pending }} MRU</td>
                                <td>{{ payment.value }} MRU</td>
                                <td>
                                    <p class="notice">
                                        {{ payment.notice }}
                                    </p>
                                </td>
                                <td>
                                    <span class="badge text-bg-primary">
                                        {{ payment.status_text }}
                                    </span>
                                </td>
                                <td class="actions-btn">
                                    <router-link :to="{path:'/dashboard/show-marketer/'+payment.marketer.id}"  class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                        تفاصيل المسوق
                                    </router-link>
                                    <button @click="SingleStatus(payment)" class="btn btn-warning btn-sm">
                                        تحديث الحالة
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
                                <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/marketers-payments/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/marketers-payments/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
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
                                <h5 class="modal-title" id="exampleModalLiveLabel">تحديث المدفوعات</h5>
                            </div>
                            <div class="modal-body">

                                <p v-if="field.marketer" class="alert alert-primary"> المسوق : {{ field.marketer }}</p>
                                <p v-if="field.value" class="alert alert-warning"> قيمة المبلغ : {{ field.value }} MRU</p>
                                 <p> حالة المدفوعات</p>
                                <select type="text" class="form-control" v-model="field.update_status">
                                    <option :value="0" selected>انتظار الدفع</option>
                                    <option :value="1">مكتمل</option>
                                    <option :value="2">مرفوض</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button @click="UpdateStatus(field.marketer ? 1 : 2)" type="button" class="btn btn-primary" fdprocessedid="3xp1pw">تحديث الحالة</button>
                                <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
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
        <div v-if="this.loading" style="position: fixed;top: 0px;bottom: 0px;background-color:#1d2024d1;left: 0;right: 0;z-index: 100000;text-align: center;">
            <img style="margin: 10% auto;" src="@/img/Enso-2.gif"/>
        </div>
    </div>
</template>
<script>
export default {
     data() {
        return {
            active_marketers:0,
            payments_due:0,
            payments_make:0,
            pending_profits:0,
            profits:0,
            infos:[],
            payments:[],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            field:{
                update_status:0,
                value:null,
                marketer:null,
                ids:[]
            },
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر',
            loading:true
        };
    },
    methods:{
        FetchMarketers:function(){
            let self = this;
            axios.get('/api/marketer-payments-index',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.payments           = self.infos.data;
                self.active_marketers   = data.active_marketers;
                self.payments_due       = data.payments_due;
                self.payments_make      = data.payments_make;
                self.profits            = data.profits;
                self.pending_profits    = data.pending_profits;
            }).catch(function({response}){
                console.log(response);
            });
        },
        ShowModelUpdateStatus:function(){
           this.showModel = true;
        },
        CloseModelUpdateStatus:function(){
           this.showModel = false;
           this.field.ids = [];
        },
        UpdateStatus:function(arg){
            let self = this;
            if(arg == 2){
                this.field.ids = this.selected;
            }
            axios.put('/api/marketers-payments',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.showsuccess = true;
                self.success_message = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                };
                self.FetchMarketers();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data;
            })
        },
        SingleStatus:function(payment){
            let self = this;
            this.field.update_status = payment.payment_status;
            this.field.value = payment.value;
            this.field.marketer = payment.marketer.name;
            this.field.ids.push(payment.id);
            this.ShowModelUpdateStatus();
        },
    },
    created:function(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
        };
        this.FetchMarketers();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {q:search};
                axios.get('/api/marketer-search-profits',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos              = [];
                    self.payments          = data.data_info;
                    self.no_active_marketer = data.no_active_marketer;
                    self.active_marketer    = data.active_marketer;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
                };
                self.FetchMarketers();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.payments.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.payments.forEach(function(item){
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
td p.notice
{
    width: 80%;
    white-space: normal !important;
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
