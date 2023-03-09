<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="UpdateDelivery">
            <div class="row">
                <h3 class="col-md-6 title-merchant">
                    <i class="fas fa-user-tie" style="font-size: 18px;"></i>
                    تعديل شركة الشحن
                </h3>

                <div class="col-md-6 container-submit-btn-merchant">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus"></i>
                        تعديل شركة الشحن مفعلا
                    </button>
                    <button type="button" @click="UpdateDraftDelivery" value="0" class="btn btn-danger">
                        <i class="fas fa-user-slash"></i>
                         تعديل شركة الشحن غير مفعل
                    </button>
                </div>
            </div>
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
                <div class="col-lg-6 container-form-new-merchant">
                    <div class="form-group">
                        <label for="merchant-name">
                           <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            اسم شركة الشحن
                        </label>
                        <input id="merchant-name" placeholder="اسم شركة الشحن" class="form-control" type="text" v-model="delivery.name"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            البريد الالكترونى
                        </label>
                        <input id="merchant-name" placeholder=" البريد الالكترونى" class="form-control" type="email" v-model="delivery.email"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                            رقم الجوال
                        </label>
                        <input id="merchant-name" placeholder="رقم الجوال" class="form-control" type="tel" v-model="delivery.phone"/>
                    </div>
                </div>
                <div class="col-lg-6 container-form-new-merchant">
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            كلمة المرور
                        </label>
                        <input id="merchant-name" placeholder="كلمة المرور" class="form-control" type="password" v-model="delivery.password"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-lock" style="padding: 5px;"></i>
                            اعادة تأكيد كلمة المرور
                        </label>
                        <input id="merchant-name" placeholder="اعادة تأكيد كلمة المرور" class="form-control" type="password" v-model="delivery.password_confirmation"/>
                    </div>
                </div>
            </div>
        </form>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
    </div>
</template>
<script>
export default {
    data(){
        return{
            delivery:{},
            errors:{},
            success:null,
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر'
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
            }).then(function(){
                self.delivery.status = 1;
            });
        },
        UpdateDelivery:function(){
            let self = this;
            axios.put('/api/deliveries/'+this.$route.params.id,this.delivery).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.showsuccess = true;
                self.success_message = data.result;
                console.log(self.success);
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data;
            })
        },
        UpdateDraftDelivery:function(){
            this.delivery.status = 0;
            this.UpdateDelivery();
        }
    },
    created(){
        this.FetchDelivery();
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
