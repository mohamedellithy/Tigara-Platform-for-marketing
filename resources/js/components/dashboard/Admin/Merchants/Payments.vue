<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <router-link :to="{name:'merchant-add-payment'}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-plus-circle"></i>
                                        اضافة مدفوعات جديدة
                                    </router-link>
                                </li>
                                <li class="filter-item">
                                    {{ payment_total }} MRU

                                     اجمالى المدفوعات
                                </li>

                                <li class="filter-item">
                                    {{ payment_pending }} MRU
                                    المدفوعات المحظورة
                                </li>

                                <li class="filter-item">
                                    {{ payment_due - payment_pending }} MRU

                                     المدفوعات الغير مسددة
                                </li>

                                <li class="filter-item">
                                    {{ payment_made }} MRU

                                     المدفوعات المسددة
                                </li>

                                <br/><br/>
                                <li class="filter-item" style="background-color: rgb(255, 234, 234);">
                                    <i class="fas fa-eye" data-v-d0b1f818=""></i>
                                    {{ merchants.length }}
                                    المعروض
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
                                <th>اسم التاجر</th>
                                <th>اسم المتجر</th>
                                <th>اجمالى المدفوعات</th>
                                <th>المدفوعات المحظورة</th>
                                <th>المدفوعات الغير مسددة</th>
                                <th>المدفوعات المسددة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(merchant, key) in merchants" :key="key">
                                <th scope="row">{{ merchant.id }}</th>
                                <td>{{ merchant.name }}</td>
                                <td>{{ merchant.store_name || '-' }}</td>
                                <td>{{ merchant.payments_total }} {{ currency }}</td>
                                <td>{{ merchant.total_pending }} {{ currency }}</td>
                                <td>{{ merchant.payments_due - merchant.total_pending }} {{ currency }}</td>
                                <td>{{ merchant.payments_made }} {{ currency }}</td>
                                <td class="actions-btn">
                                    <router-link :to="{path:'/dashboard/show-payments-merchant/'+merchant.id}"  class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                           تفاصيل المدفوعات
                                    </router-link>
                                    <router-link :to="{path:'/dashboard/merchant-add-payment/'+merchant.id}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                        اضافة مدفوعات
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > merchants.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/payments/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/payments/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/payments/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
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
            payment_due:0,
            payment_made:0,
            payment_total:0,
            payment_pending:0,
            infos:[],
            merchants:[],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            currency:'MRU',
            field:{
                update_status:0,
                ids:[]
            },
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء المدفوعات بنجاح',
            error_message:'حدث خطأ اثناء حذف المدفوعات',
            loading:true
        };
    },
    methods:{
        FetchMerchantPayments:function(){
            let self = this;
            axios.get('/api/merchant-payments',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.merchants          = self.infos.data;
                self.payment_total      = data.payment_total;
                self.payment_due        = data.payment_due;
                self.payment_made       = data.payment_made;
                self.payment_pending    = data.payment_pending;
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
        };
        this.FetchMerchantPayments();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {q:search};
                axios.get('/api/merchant-payments/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos              = [];
                    self.merchants          = data.data_info;
                    self.payment_due        = data.payment_due;
                    self.payment_made       = data.payment_made;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
                };
                self.FetchMerchantPayments();
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
    margin: 3px;
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
