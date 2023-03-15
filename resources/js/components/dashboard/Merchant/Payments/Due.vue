<template>
    <div class="container-body-merchant">
        <div class="row">
            <div class="filter-bar">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="filter-results">
                            <li class="filter-item">
                                <i class="fas fa-users"></i>
                                {{ payments_total }} اجمالى المبالغ 
                            </li>
                            <li class="filter-item">
                                <i class="fas fa-users"></i>
                                {{ payments_due }} اجمالى المبالغ الغير مسددة
                            </li>
                            <li class="filter-item">
                                <i class="fas fa-users"></i>
                                {{ payments_made }} اجمالى المبالغ  مسددة
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
                                <th>قيمة المبلغ</th>
                                <th>تفصيل الطلب</th>
                                <th>حالة المدفوعات</th>
                                <th>تاريخ الاضافة</th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(payment, key) in payments" :key="key">
                                <th scope="row">#{{ payment.id }}</th>
                                <td>{{ payment.value }} USD</td>
                                <td>
                                    <template v-if="payment.item_id">
                                        <strong> ( {{ payment.item_details.product_name  }} ) </strong>
                                        (
                                            {{ payment.item_details.quantity  }} قطعة
                                            <i class="fas fa-times" style="margin: 10px;color:red"></i>
                                            {{ payment.item_details.unit_price }} USD
                                        )
                                    </template>
                                    <template v-if="payment.type == 1">
                                         -
                                    </template>
                                </td>
                                <td>
                                    <template v-if="payment.item_id">
                                        <strong v-if="payment.pending_payment"> 
                                            <span class="badge text-bg-danger">محظورة</span>
                                        </strong>
                                    </template>
                                    <template v-else>
                                        متاحة
                                    </template>
                                </td>
                                <td>{{ payment.created_at }}</td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
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
            payments_total:0,
            payments_made:0,
            payments_due:0,
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
            iconsProfile
        }
    },
    methods:{
        FetchPayments:function(){
            let self = this;
            axios.get('/api/merchant-due-payments',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos             = data.data_info;
                self.payments          = self.infos.data;
                self.payments_total    = data.payments_total;
                self.payments_made     = data.payments_made;
                self.payments_due      = data.payments_due;
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
            merchant_id:this.$route.params.id
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
