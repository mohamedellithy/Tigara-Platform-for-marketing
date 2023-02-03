<template>
    <div class="col-12" v-if="Object.keys(campaigns).length != 0">
        <div class="row container-top-content">
            <div class="col-lg-8">
                <button class="btn btn-success btn-sm"  @click="RollBackTrashAllCampaigns">استرجاع الكل</button>
                <button class="btn btn-danger  btn-sm"  @click="PermanentlyTrashAllCampaigns">حذف الكل نهائي</button>
                <button type="submit" class="btn btn-danger  btn-sm"  @click="PermanentlyTrashSelectedCampaigns" :disabled="(trashs.length == 0)">حذف المحدد</button>
                <button type="submit" class="btn btn-danger  btn-sm"  @click="RollBackTrashSelectedCampaigns" :disabled="(trashs.length == 0)">استرجاع المحدد</button>
            </div>
        </div>
        <div class="row">
            <div class="container-card col-md-4" v-for="(campaign,index) in campaigns" :key="index">
                <div class="card">
                    <div class="status">
                        <span class="badge">
                            <input type="checkbox" v-model="trashs" :value="campaign.id"/>
                        </span>
                        <span class="badge text-bg-danger rollback-trash" @click="PermanentlyTrashCampaign(campaign.id)">
                           <i class="fas fa-trash"></i>
                            حذف نهائي
                        </span>
                    </div>
                    <div class="header-top-card">
                        <h6>{{ campaign.name }}</h6>
                    </div>
                    <div class="body-card">
                        <div class="container-description">
                            <p class="description">{{ campaign.description }}</p>
                            <hr/>
                        </div>
                    </div>
                    <div class="footer-card">
                        <button type="button" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                            تقاصيل الحملة
                        </button>
                        <button @click="RollBackTrashCampaign(campaign.id)" type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-retweet"></i>
                            استرجاع الحملة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="col-lg-8 show-alert-messaage">
         <img class="schedule-img" :src="require('../../../img/image_processing20200627-19092-c2s8xo.gif')">
         <p class="description-schedule-empty">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus tenetur nam adipisci deserunt consequuntur eius laboriosam, eaque eveniet assumenda esse. Cumque architecto culpa cupiditate dolorem ipsa, quae neque repudiandae impedit.</p>
         <div class="frame-btn-schedule">
              <router-link tag="button" class="btn btn-success" :to="{name:'add-schedules'}">اضافة حملة جديدة</router-link>
         </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
          campaigns:{key:null},
          trashs:[]
        }
    },
    methods:{
        PermanentlyTrashCampaign:function(id){
            let self = this;
            if(confirm('Are you sure to delete permanently ? ') == false){
                return;
            }

            axios.post('/api/campaign/permanently-trashed',{
                campaign_id : [id]
            }).then(function({data}){
                console.log(data);
                self.fetchTrashs();
            }).catch(function({response}){
                console.log(response);
            });
        },
        PermanentlyTrashAllCampaigns:function(){
            // permantaly all trashs
            let self = this;
            if(confirm('Are you sure to delete all permanently ? ') == false){
                return;
            }

            axios.post('/api/campaign/permanently-trashed').then(function({data}){
                console.log(data);
                self.fetchTrashs();
            }).catch(function({response}){
                console.log(response);
            });
        },
        PermanentlyTrashSelectedCampaigns:function(){
            // trash selected
            let self = this;
            if(confirm('Are you sure to delete selected permanently ? ') == false){
                return;
            }

            axios.post('/api/campaign/permanently-trashed',{
                campaign_id : self.trashs
            }).then(function({data}){
                console.log(data);
                self.fetchTrashs();
            }).catch(function({response}){
                console.log(response);
            });
        },
        RollBackTrashAllCampaigns:function(){
            // rollback all trashs
            let self = this;
            if(confirm('Are you sure to restore all deletes ? ') == false){
                return;
            }

            axios.post('/api/campaign/rollback-trashed').then(function({data}){
                console.log(data);
                self.fetchTrashs();
            }).catch(function({response}){
                console.log(response);
            });
        },
        RollBackTrashCampaign:function(id){
            // rollback trash
            let self = this;

            if(confirm('Are you sure to restore item ? ') == false){
                return;
            }

            axios.post('/api/campaign/rollback-trashed',{
                campaign_id : [id]
            }).then(function({data}){
                console.log(data);
                self.fetchTrashs();
            }).catch(function({response}){
                console.log(response);
            });
        },
        RollBackTrashSelectedCampaigns:function(){
            // trash selected
            let self = this;
            if(confirm('Are you sure to delete selected permanently ? ') == false){
                return;
            }

            axios.post('/api/campaign/rollback-trashed',{
                campaign_id : self.trashs
            }).then(function({data}){
                console.log(data);
                self.fetchTrashs();
            }).catch(function({response}){
                console.log(response);
            });
        },
        fetchTrashs:function(){
            let self = this;
            axios.get('/api/campaign/trashed').then(function({data}){
                self.campaigns = data.campaigns;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created(){
        this.fetchTrashs();
    }
}
</script>
<style scoped>
.row{
    margin: 0px;
}
.show-alert-messaage{
    height:auto;
    /*background-color: antiquewhite;*/
    padding:20px;
    text-align:center;
    margin:auto;
    margin-top:5%;
}

.schedule-img{
    width: 31%;
    height: 220px;
    border-radius: 60%;
}

p.description-schedule-empty{
    padding: 6% 15%;
}
.container-card{
    padding: 20px;
}
.card{
    padding: 25px;
    border: 1px solid #e0dfdf;
    border-radius: 1px;
    box-shadow: 0px 5px 10px 8px #eee;
}
.header-top-card h6{
    line-height: 2em;
    font-size: 19px;
    padding: 14px 0px;
}
.props-card{
    width: 100%;
    padding: 0px 20px;
}
.props-card li{
        padding: 12px 13px;
}
.badge{
    font-size: 13px !important;
}
.footer-card .btn{
    font-size: 11px;
}
.container-top-content{
    padding: 16px 9px 0px;
}
.card .status{
    position: relative;
}
.card .status .rollback-trash{
    position: absolute;
    left: 0;
    top: 4px;
    font-size: 18px;
    cursor: pointer;
}
@media(max-width:1000px){
    .schedule-img{
        width: 70%;
        height: auto;
    }
}
</style>
