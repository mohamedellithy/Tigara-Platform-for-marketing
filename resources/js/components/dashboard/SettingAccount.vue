<template>
    <div class="container-body-merchant">
        <div class="row">
            <div class="col-lg-11 profile-image">
                <img :src="iconsProfile" />
                <p>
                    <label style="font-size:13px;color: #f24513;font-weight: bold;">
                        {{ this.user.name }}
                    </label>
                    <br/>
                    <template v-if="this.user.account_type == 0">
                        مسؤل
                    </template>
                    <template v-if="this.user.account_type == 1">
                        تاجر
                    </template>
                    <template v-if="this.user.account_type == 2">
                        شركة شحن
                    </template>
                    <template v-if="this.user.account_type == 3">
                        مسوق
                    </template>
                </p>
            </div>
            <p style="color: #f24913;font-size: 14px;font-weight: bold;">اعدادات الحساب</p>
            <div class="col-lg-6 container-form-new-merchant">
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اسم
                    </label>
                    <p v-if="!update.name" class="container-value-p">
                        {{ this.user.name }}
                        <i @click="update.name = this.user.name;field.name = this.user.name" class="fas fa-edit edit-tab-icon"></i>
                    </p>
                    <p v-else-if="update.name" style="text-align: left;">
                        <form method="post" @submit.prevent="UpdateUserSetting">
                            <input v-model="field.name" class="form-control" type="text" required/>
                            <button type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;">
                                <i class="fas fa-save"></i>
                                حفظ التعديل
                            </button>
                        </form>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        البريد الالكترونى
                    </label>
                    <p class="container-value-p">{{ this.user.email }}</p>
                </div>

            </div>
            <div class="col-lg-6 container-form-new-merchant">
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        رقم الجوال
                    </label>
                    <p v-if="!update.phone"  class="container-value-p">
                        {{ this.user.phone }}
                        <i @click="update.phone = this.user.phone;field.phone = this.user.phone" class="fas fa-edit edit-tab-icon"></i>
                    </p>
                    <p v-else-if="update.phone" style="text-align: left;">
                        <form method="post" @submit.prevent="UpdateUserSetting">
                            <input v-model="field.phone" class="form-control" type="text" required/>
                            <button type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;">
                                <i class="fas fa-save"></i>
                                حفظ التعديل
                            </button>
                        </form>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        كلمة المرور
                    </label>
                    <p v-if="!update.password"  class="container-value-p">
                        **********
                        <i @click="update.password = true;" class="fas fa-edit edit-tab-icon"></i>
                    </p>
                    <p v-else-if="update.password" style="text-align: left;">
                        <i @click="showPasswordConfirm = false"  class="fas fa-eye img-show-hide-password" v-if="showPasswordConfirm == true"></i>
                        <i @click="showPasswordConfirm = true"  class="fas fa-eye-slash img-show-hide-password" v-if="showPasswordConfirm == false"></i>
                        <form method="post" @submit.prevent="UpdateUserSetting">
                            <input v-model="field.password" class="form-control" :type="showPasswordConfirm == true ? 'text' : 'password' "  required/>
                            <br/>
                            <p style="text-align:right">
                                <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                                تأكيد كلمة المرور
                            </p>
                            <input v-model="field.password_confirmation" class="form-control" :type="showPasswordConfirm == true ? 'text' : 'password' "  required/>
                            <button type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;">
                                <i class="fas fa-save"></i>
                                حفظ التعديل
                            </button>
                        </form>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        تاريخ التسجيل
                    </label>
                    <p class="container-value-p">{{ this.user.created_at }}</p>
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
import iconsProfile from '@/img/Circle-icons-profile.svg.png';
export default {
    components:{
        iconsProfile
    },
    data(){
        return{
            user:{},
            errors:{},
            success:null,
            iconsProfile,
            field:{},
            update:{},
            errors:{},
            success:null,
            showsuccess:false,
            showerrors:false,
            success_message:'تم تعديل البيانات  بنجاح',
            error_message:'حدث خطأ اثناء تعديل البيانات',
            showPasswordConfirm:false
        }
    },
    methods:{
        UpdateUserSetting:function(){
            let self = this;
            axios.put('/api/users',this.field).then(function({data}) {
                console.log(data);
                self.showsuccess = true;
                self.success_message = data.result;
                self.update   = {};
                self.errors  = {};
                console.log(self.success);
                self.user = data.user;
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data.errors;
            })
        }
    },
    created:function(){
        this.user = this.$auth.user;
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
    position: relative;
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
.edit-tab-icon{
    position: absolute;
    left: 15px;
    top: 13px;
    cursor: pointer;
    color: #212529;
}
</style>
