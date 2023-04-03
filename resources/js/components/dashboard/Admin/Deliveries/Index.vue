<template>
    <div class="container">
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <button  @click="TruncateDeliveries()" class="btn btn-danger btn-sm">
                                        حذف الكل
                                    </button>
                                    <button @click="DeleteSelectedDeliveries()" class="btn btn-danger btn-sm" :disabled="(selected.length == 0)">
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
                                    {{ all_deliveries }} شركة الشحن
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ active_deliveries }} مفعل
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ no_active_deliveries }} غير مفعل
                                </li>
                                <br/><br/>
                                <li class="filter-item" style="background-color: rgb(255, 234, 234);">
                                    <i class="fas fa-eye"></i>
                                    {{ deliveries.length }} شركة الشحن
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى شركات الشحن" v-model="search" class="form-control search-input"/>
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
                                <th>اسم </th>
                                <th>البريدالالكترونى</th>
                                <th>رقم الجوال</th>
                                <th>حال </th>
                                <th>اجمالى الطلبات</th>
                                <th>اجمالى المبيعات</th>
                                <th> أرباح</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(delivery, key) in deliveries" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="delivery.id" :checked="selected.indexOf(delivery.id) != -1"/>
                                </th>
                                <th scope="row">{{ delivery.id }}</th>
                                <td>{{ delivery.name }}</td>
                                <td>{{ delivery.email }}</td>
                                <td>{{ delivery.phone }}</td>
                                <td>
                                    <template v-if="delivery.status == 0">
                                        غير مفعل
                                    </template>
                                    <template v-if="delivery.status == 1">
                                         مفعل
                                    </template>
                                </td>
                                <td>{{ delivery.total_orders }} طلبية</td>
                                <td>{{ delivery.total_sales }} MRU</td>
                                <td>{{ delivery.total_delivery_profits }} MRU</td>
                                <td class="actions-btn">
                                    <button @click="DeleteDelivery(delivery.id,delivery.name)" class="btn btn-danger btn-sm">
                                        حذف
                                    </button>
                                    <router-link :to="{path:'/dashboard/show-delivery/'+delivery.id}"  class="btn btn-primary btn-sm">
                                        عرض
                                    </router-link>
                                    <router-link :to="{path:'/dashboard/edit-delivery/'+delivery.id}" class="btn btn-warning btn-sm">
                                        تعديل
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > deliveries.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/deliveries/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/deliveries/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
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
                            <h5 class="modal-title" id="exampleModalLiveLabel">تحديث الحالة لشركة الشحن</h5>
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
            no_active_deliveries:0,
            active_deliveries:0,
            all_deliveries:0,
            infos:[],
            deliveries: [],
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
        FetchDeliveries:function(){
            let self = this;
            axios.get('/api/deliveries',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos              = data.data_info;
                self.deliveries          = self.infos.data;
                self.all_deliveries       = data.all_deliveries;
                self.no_active_deliveries = data.no_active_deliveries;
                self.active_deliveries    = data.active_deliveries;
                console.log(self.deliveries);
            }).catch(function({response}){
                console.log(response);
            });
        },
        DeleteDelivery:function(id,name){
            if(confirm(`تأكيد حذف شركة الشحن ${ name }`)){
                let self = this;
                axios.delete('/api/deliveries/'+id).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.showsuccess = true;
                    self.success_message = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                    };
                    self.FetchDeliveries();
                }).catch(function({response}){
                    console.log(response);
                    self.showerrors = true;
                    self.errors = response.data;
                });
            }
        },
        TruncateDeliveries:function(){
            if(confirm(`تأكيد حذف كل شركات الشحن`)){
                let self = this;
                axios.delete('/api/deliveries/delete-selected',{
                    params:{
                        type:'all'
                    }
                }).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.showsuccess = true;
                    self.success_message = data.result;
                    self.params = {
                        page:1
                    };
                    self.FetchDeliveries();
                }).catch(function({response}){
                    console.log(response);
                    self.showerrors = true;
                    self.errors = response.data;
                });
            }
        },
        DeleteSelectedDeliveries:function(){
            if(confirm(`تأكيد حذف شركات الشحن المحددة`)){
                let self = this;
                axios.delete('/api/deliveries/delete-selected',{
                    params:{
                        type:'selected',
                        deliveries:self.selected
                    }
                }).then(function({data}){
                    console.log(data);
                    self.errors   = {};
                    self.showsuccess = true;
                    self.success_message = data.result;
                    self.params = {
                        page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                    };
                    self.FetchDeliveries();
                }).catch(function({response}){
                    console.log(response);
                    self.showerrors = true;
                    self.errors = response.data;
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
            axios.put('/api/deliveries/update-status',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.showsuccess = true;
                self.success_message = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                };
                self.FetchDeliveries();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data;
            })
        }
    },
    created:function(){
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
        };
        this.FetchDeliveries();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params = {q:search};
                axios.get('/api/deliveries/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos                 = [];
                    self.deliveries            = data.data_info;
                    self.no_active_deliveries  = data.no_active_deliveries;
                    self.active_deliveries     = data.active_deliveries;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1)
                };
                self.FetchDeliveries();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.deliveries.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.deliveries.forEach(function(item){
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
@media(max-width:1000px){
    .container-submit-btn-merchant button{
        margin: 1px;
        font-size: 10px;
    }
    .filter-bar .filter-results .filter-item{
        font-size: 11px;
        margin-bottom: 2px;
    }
}
</style>
