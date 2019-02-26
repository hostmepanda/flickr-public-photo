<?


?>


<html>
  <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-light bg-secondary">
        <span class="navbar-brand mb-0 h1 text-white">Flickr public photo getter</span>
        <small class='text-muted'>see docs: <a class='text-white' href='https://www.flickr.com/services/feeds/docs/photos_public/'>Flickr docs</a></small>
      </nav>
      <div class="alert " id="vSearch">
        <div class="row justify-content-around">
          <div class="col-4">
            <div class="alert alert-primary">
              <h5 class="col-12 text-center p-1">Search options</h5>
              <div class="">
                <div class="alert p-0">
                  <label class="col-12">User ID <span class=""  :title="search.labels.ids"><i class="far fa-question-circle"></i></span></label>
                  <input class="form-control form-control-sm" v-model="search.fields.ids"/>
                </div>
                <div class="alert p-0">
                  <div class="row justify-content-center">
                    <div class="col-6">
                      <label class="col-12">Tags list <span class=""  :title="search.labels.tags"><i class="far fa-question-circle"></i></span></label>
                      <input class="form-control form-control-sm" v-model="search.fields.tags"/>
                    </div>
                    <div class="col-6">
                      <label class="col-12 text-center">Tags <span class=""  :title="search.labels.tagMode"><i class="far fa-question-circle"></i></span></label>
                      <div class="btn btn-sm col-12" :class="{'btn-primary':!search.fields.tagMode,'btn-outline-secondary':search.fields.tagMode}" @click="search.fields.tagMode=false">
                        ALL
                      </div>
                      <div class="btn btn-sm col-12 mt-1" :class="{'btn-primary':search.fields.tagMode,'btn-outline-secondary':!search.fields.tagMode}" @click="search.fields.tagMode=true">
                        ANY
                      </div>
                    </div>
                  </div>

                </div>
                <div class="alert p-0">
                  <div class="row">
                    <div class="col-12">
                      <label class="col-12 text-center">Language<span class=""  :title="search.labels.lang"><i class="far fa-question-circle"></i></span></label>
                      <select class="form-control" v-model="search.fields.selectedLang">
                        <option v-for="(lang, lKey, lInd) in search.fields.lang" :value="lKey">
                          {{lang}}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 alert">
                  <div class="col-12 btn btn-warning btn-sm" @click="getFeed()" v-if="!search.loading">
                    Get feed
                  </div>
                  <div v-else class="col-12 btn btn-warning btn-sm" v-if="search.loading">
                    <i class="fas fa-sync fa-spin"></i>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="col-8">
            <div class="row justify-content-center">
              <template v-if="feed.error">
                <div class="col-11 text-center alert alert-danger">
                  Bad request
                </div>
              </template>
              <template v-else>
                <div class="col-4 text-center alert p-1" v-for="(feed, fKey, fInd) in feed.payload">
                  <div class="row justify-content-center">
                    <div class="col-12">
                      <a :href="feed.author.uri">{{ feed.author.name }}</a>
                    </div>
                    <div class="col-12">
                      <img :src="formatIMG(feed.link)" width="180px" style="overflow-y: hidden;max-height: 150px;"/>
                    </div>
                    <div class="col-12">
                      {{ formatTitle(feed.title) }}
                    </div>
                    <template v-if="feed.category.length">
                      <div class="alert p-1 col-11">
                        <div class="col-12">
                          Tag list
                        </div>
                        <span class="badge badge-primary mr-1 mt-1" v-for="(attr, attrInd, attrKey) in feed.category">{{ (""+attr["@attributes"]["term"]).substr(0,20) }}</span>
                      </div>
                    </template>
                  </div>
                </div>
              </template>

            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="include/js/flickr.public.photo.vue.js"></script>

</html>
