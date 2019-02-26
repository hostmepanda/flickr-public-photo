let vSearch=new Vue({
  el:"#vSearch",
  data:{
    search:{
      loading:false,
      labels:{
        ids:"A comma delimited list of user IDs",
        tags:"A comma delimited list of tags to filter the feed by",
        tagMode:"Control whether items must have ALL the tags or ANY of the tags",
        format:"The format of the feed",
        lang:"The display language for the feed"
      },
      fields:{
        ids:"",
        tags:"",
        tagMode:0,
        format:["rss2","atom","rss_091","rss","rdf","rss_200_enc"],
        lang:["de-de","en-us","es-us","fr-fr","it-it","ko-kr","pt-br","zh-hk"],
        selectedFormat:1,
        selectedLang:1,
      }
    },
    feed:{
      lastUpdate:"",
      payload:{},
      error:false,
    },
  },
  methods:{
    formatTitle:function(title){
      if(typeof(title)=="string"){
        return (""+title).substr(0,20);
      }
      if(typeof(title)=="object"){
        if(typeof(title[0])!="undefined" && (""+title[0]).trim()!=''){
          return (""+title[0]).substr(0,20);
        }
      }
      return "No title";
    },
    formatIMG:function(img){
      for(let i=0; i<Object.keys(img).length; i++){
        if(img[Object.keys(img)[i]]['@attributes']['type']=="image/jpeg"){
          return (""+img[Object.keys(img)[i]]['@attributes']['href']).replace(/_b/,'_m');
        }
      }

      return false; //link to no image if needed
    },
    getFeed:function(){
      this.search.loading=true;
      let data={
        id:this.search.fields.ids,
        tags:this.search.fields.tags,
        tagMode:this.search.fields.tagMode,
        format:this.search.fields.format[this.search.fields.selectedFormat],
        lang:this.search.fields.lang[this.search.fields.selectedLang],
      };

      axios({
        "url":"include/php/retrFeed.php",
        "method":"POST",
        data:data,
      }).then(r=>{

        vSearch.search.loading=false;

        if(r.data.r==200){
          vSearch.feed.error=false;
          vSearch.feed.lastUpdate=(new Date()).toLocaleTimeString("ru")+" "+(new Date()).toLocaleDateString("ru");
          vSearch.feed.payload=r.data.payload.entry;
        }
        if(r.data.r==400){
          vSearch.feed.error=true;

        }
      }).catch(err=>{
        console.log(err);
      });
    }
  }
});
