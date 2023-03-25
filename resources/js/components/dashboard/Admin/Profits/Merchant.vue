<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ all_merchants  }} عدد  التجار
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ total_sales }} اجمالى المبيعات
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ total_merchant_products_sales }} اجمالى مبيعات التجار
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ total_platform_profits }} اجمالى أرباح المنصة
                                </li>
                                <br/> <br/>
                                <li class="filter-item" style="background-color: #ffeaea;">
                                    <i class="fas fa-eye"></i>
                                    {{ merchants.length }} معروض
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى التجار" v-model="search" class="form-control search-input"/>
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
                                <th>اسم التاجر</th>
                                <th>اسم المتجر</th>
                                <th>اجمالى الطلبات</th>
                                <th>اجمالى المبيعات</th>
                                <th>اجمالى أرباح المنصة</th>
                                <th>المبالغ الغير مسددة</th>
                                <th>المبالغ المسددة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(merchant, key) in merchants" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="merchant.id" :checked="selected.indexOf(merchant.id) != -1"/>
                                </th>
                                <th>
                                    {{ merchant.id }}
                                </th>
                                <td>{{ merchant.name }}</td>
                                <td>{{ merchant.store_name || '-' }}</td>
                                <td>{{ merchant.total_compelete_orders }} طلبية</td>
                                <td>{{ merchant.total_merchant_products_sales }} USD</td>
                                <td>{{ merchant.total_platform_profits }} USD</td>
                                <td>{{ merchant.payments_due }} USD</td>
                                <td>{{ merchant.payments_made }} USD</td>
                                <td class="actions-btn">
                                    <router-link :to="{path:'/dashboard/show-merchant/'+merchant.id}"  class="btn btn-primary btn-sm">
                                        عرض
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
                                <router-link class="page-link" :to="{path: '/dashboard/merchants/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/merchants/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/merchants/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
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
            total_sales:0,
            total_merchant_products_sales:0,
            total_platform_profits:0,
            all_merchants:0,
            infos:[],
            merchants:[],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            errors:{},
            success:null,
            showModel:false,
            field:{
                update_status:0,
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
        FetchMerchants:function(){
            let self = this;
            axios.get('/api/merchants',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.merchants          = self.infos.data;
                self.total_merchant_products_sales = data.total_merchant_products_sales;
                self.total_sales    = data.total_sales;
                self.total_platform_profits = data.total_platform_profits;
                self.all_merchants      = data.all_merchants;
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created:function(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
            merchant_profits:true
        };
        this.FetchMerchants();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {
                    q:search,
                    merchant_profits:true
                };
                axios.get('/api/merchants/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos              = [];
                    self.merchants          = data.data_info;
                    // self.no_active_merchant = data.no_active_merchant;
                    // self.active_merchant    = data.active_merchant;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
                    merchant_profits:true
                };
                self.FetchMerchants();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.merchants.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.merchants.forEach(function(item){
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
