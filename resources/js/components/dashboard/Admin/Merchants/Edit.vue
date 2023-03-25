<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="UpdateMerchant">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-user-tie" style="font-size: 18px;"></i>
                    تعديل التاجر
                </h3>

                <div class="col-md-4 container-submit-btn-merchant">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus"></i>
                        تعديل التاجر مفعلا
                    </button>
                    <button type="button" @click="UpdateDraftMerchant" value="0" class="btn btn-danger">
                        <i class="fas fa-user-slash"></i>
                         تعديل التاجر غير مفعل
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 container-form-new-merchant">
                    <div class="form-group">
                        <label for="merchant-name">
                           <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            اسم التاجر
                        </label>
                        <input id="merchant-name" placeholder="اسم التاجر" class="form-control" type="text" v-model="merchant.name"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            البريد الالكترونى
                        </label>
                        <input id="merchant-name" placeholder=" البريد الالكترونى" class="form-control" type="email" v-model="merchant.email"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                            رقم الجوال
                        </label>
                        <input id="merchant-name" placeholder="رقم الجوال" class="form-control" type="text" v-model="merchant.phone"/>
                    </div>
                </div>
                <div class="col-lg-6 container-form-new-merchant">
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            اسم المتجر
                        </label>
                        <input id="merchant-name" placeholder="اسم المتجر" class="form-control" type="text" v-model="merchant.store_name"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            كلمة المرور
                        </label>
                        <input id="merchant-name" placeholder="كلمة المرور" class="form-control" type="password" v-model="merchant.password"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            اعادة تأكيد كلمة المرور
                        </label>
                        <input id="merchant-name" placeholder="اعادة تأكيد كلمة المرور" class="form-control" type="password" v-model="merchant.password_confirmation"/>
                    </div>
                </div>
            </div>
        </form>
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
    data(){
        return{
            merchant:{},
            errors:{},
            field:{},
            success:null,
            showsuccess:false,
            showerrors:false,
            success_message:'تم تحديث التاجر بنجاح',
            error_message:'حدث خطأ اثناء تحديث التاجر',
            loading:true
        }
    },
    methods:{
        FetchMerchant:function(){
            let self = this;
            axios.get('/api/merchants/'+this.$route.params.id).then(function({data}) {
                console.log(data);
                self.merchant = data.merchant;
            }).catch(function({response}) {
                console.log(response);
            }).then(function(){
                self.merchant.status = 1;
            });
        },
        UpdateMerchant:function(){
            let self = this;
            this.merchant.account_type = 1;
            axios.put('/api/merchants/'+this.$route.params.id,this.merchant).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success_message  = data.result;
                self.showsuccess = true;
                console.log(self.success);
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data;
            })
        },
        UpdateDraftMerchant:function(){
            this.merchant.status = 0;
            this.UpdateMerchant();
        }
    },
    created(){
        this.FetchMerchant();
    },
    mounted:function(){
        let self = this;
        setTimeout(() => {
            self.loading = false;
        }, 1000);
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
    padding: 10px;
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
</style>
