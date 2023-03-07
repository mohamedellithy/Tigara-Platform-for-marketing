<template>
    <div class="container-body-merchant">
        <form @submit.prevent="CreateNewMerchant">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-user-tie" style="font-size: 18px;"></i>
                    اضافة تاجر جديد
                </h3>

                <div class="col-md-4 container-submit-btn-merchant">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus"></i>
                        اضافة التاجر مفعلا
                    </button>
                    <button type="button" @click="CreateNewDraftMerchant" value="0" class="btn btn-danger">
                        <i class="fas fa-user-slash"></i>
                         اضافة التاجر غير مفعل
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
                        <input id="merchant-name" placeholder="اسم التاجر" class="form-control" type="text" v-model="field.name"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            البريد الالكترونى
                        </label>
                        <input id="merchant-name" placeholder=" البريد الالكترونى" class="form-control" type="email" v-model="field.email"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                            رقم الجوال
                        </label>
                        <input id="merchant-name" placeholder="رقم الجوال" class="form-control" type="tel" v-model="field.phone"/>
                    </div>
                </div>
                <div class="col-lg-6 container-form-new-merchant">
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            اسم المتجر
                        </label>
                        <input id="merchant-name" placeholder="اسم المتجر" class="form-control" type="text" v-model="field.store_name"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            كلمة المرور
                        </label>
                        <input id="merchant-name" placeholder="كلمة المرور" class="form-control" type="password" v-model="field.password"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            اعادة تأكيد كلمة المرور
                        </label>
                        <input id="merchant-name" placeholder="اعادة تأكيد كلمة المرور" class="form-control" type="password" v-model="field.password_confirmation"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
</template>
<script>
export default {
    data(){
        return{
            field:{
                status:0,
                name:null,
                email:null,
                phone:null,
                password:null,
                account_type:1,
                password_confirmation:null
            },
            errors:{},
            success:null,
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر'
        }
    },
    methods:{
        CreateNewMerchant:function(){
            let self = this;
            axios.post('/api/merchants',this.field).then(function({data}){
                console.log(data);
                // self.success = data.result;
                self.success_message = data.result;
                self.showsuccess = true;
                self.errors  = {};
                self.field   = {};
            }).catch(function({response}) {
                self.showerrors = true;
                console.log(response);
                self.errors = response.data;
            });
        },
        CreateNewDraftMerchant:function(){
            this.field.status = 0;
            this.CreateNewMerchant();
        }
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
   /* background-color: #ffeced; */
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
