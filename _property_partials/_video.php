<section class="bg-theme-orange " style="padding:20px 0 100px 0;" id="video">
  <div class="container">
    <div class="row">
      <div class="col">

        <ul class="nav nav-pills mb-3 justify-content-center nav-video" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
              Video
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
              Virtual Tour
            </a>
          </li>

        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

            <div class="row">
              <div class="col">
                <div class="ratio ratio-16x9">
                  <iframe id="videoFrame" src="" title="3D"></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
      
            <div class="row">
              <div class="col">
                <div class="ratio ratio-16x9">
                  tour
                  <iframe id="tourFrame" src="" title="3D"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script type="text/x-handlebars-template" id='videoItemTemplate'>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
    
    {{#each data}}
      <div class="carousel-item">
      <div class="ratio ratio-16x9">
                  <iframe src="{{video_link}}" title="3D"></iframe>
                </div>
      </div>
    {{/each}}
   
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</script>

<script type="text/x-handlebars-template" id='tourItemTemplate'>
  <div id="carouselExampleControls2" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

    {{#each data}}
      <div class="carousel-item">
      <div class="ratio ratio-16x9">
                  <iframe src="{{tour_link}}" title="3D"></iframe>
                </div>
      </div>
    {{/each}}


    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


</script>