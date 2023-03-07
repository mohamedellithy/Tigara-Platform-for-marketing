<template>
    <div>
        <div id="alert-message-#1" class="alert-message-success" :class="[this.showsuccess == true ? 'active' : '' ]">
            <template>
                <i class="fas fa-check-circle"></i>
            </template>
            {{ success_message }}
        </div>
        <div id="alert-message-#2" class="alert-message-error" :class="[this.showerrors == true ? 'active' : '' ]">
            <template>
                <i class="fas fa-exclamation-circle"></i>
            </template>
            <template v-if="this.errors && Object.keys(this.errors).length !== 0">
                   <span v-for="(error,index) in errors" :key="index">{{ error[0] }}</span>
            </template>
            <template v-else>
                {{ error_message }}
            </template>
        </div>
    </div>
</template>

<style>
.alert-message-success{
    position: fixed;
    left: 5%;
    top: 20%;
    background-color: #15655a;
    padding: 14px;
    color: white;
    /* box-shadow: 0px 4px 15px 3px #cbcbcb; */
    opacity: 0;
    display: none;
    z-index: 10000000000;
}
.alert-message-error{
    position: fixed;
    left: 5%;
    top: 20%;
    background-color: #f44336;
    padding: 14px;
    color: white;
    /* box-shadow: 0px 4px 15px 3px #cbcbcb; */
    opacity: 0;
    display: none;
    z-index: 10000000000;
}
.alert-message-error.active,
.alert-message-success.active{
    display: block;
   animation: alertmessage .3s ease-out forwards;
}
@keyframes alertmessage{
    to{
        opacity: 1;
        top: 15%
    }
}
</style>
<script>
export default {
    props:{
        showsuccess:{
            default:false,
            type:Boolean
        },
        showerrors:{
            default:false,
            type:Boolean
        },
        errors:{
            default:null,
        },
        success_message:{
            default:'تم تحدبث المعلومات بنجاح',
        },
        error_message:{
            default:'حدث خطأ اثناء تحديث البيانات',
        }
    },
    watch:{
        showsuccess:function(value){
            let self = this;
           if(value == true){
            setTimeout(function(){
                self.$emit('update_success');
              },5000);
           }
        },
        showerrors:function(value){
            let self = this;
           if(value == true){
              setTimeout(function(){
                self.$emit('update_errors');
              },5000);
           }
        }
    }
}
</script>
