<template>
    <div class="container">
        <div v-if="loading" class="d-flex justify-content-center load">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
      <div v-else id="carrouselmain" class="carousel slide pointer-event" data-bs-ride="false">
        <div class="carousel-indicators">
          <button type="button" v-for="(image, index) in items" :key="index" :class="{ active: index === 0 }" :aria-label="'Slide ' + (index + 1)" data-bs-target="#carrouselmain" :data-bs-slide-to="index"></button>
        </div>
        <div class="carousel-inner">
          <div v-for="(image, index) in items" :key="index" :class="{ 'carousel-item': true, active: index === 0 }">
            <img :src="'images/' + image.carousel_image" class="bd-placeholder-img" focusable="false" preserveaspectratio="xMidYMid slice" aria-hidden="true" height="680" :alt="'Imagen ' + image.carousel_title">
            <div class="carousel-caption d-none d-md-block">
              <h5>{{ image.carousel_title }}</h5>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carrouselmain" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrouselmain" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'Carousel',
    props: {
      items: Array,
      loading: Boolean,
    },
  };
  </script>


<style scoped>

.load {
    margin-top: 66px;
}

.carousel-item {
    height: 680px;
    border-radius: 10px;
}

.carousel-caption {
    border-radius: 10px;
}

/* background shadown text h5*/
.carousel-caption h5 {
    /* shadown text */
    text-shadow: 2px 2px 5px #000000be;
    padding: 10px;
    border-radius: 10px;
    color: #fff;
}


.carousel-item img {
    margin-top: 66px;
    width: 100%;
    border-radius: 10px;
}

.carousel-control-prev, .carousel-control-next {
    border-radius: 10px;
}

/* boder radius indicators */
.carousel-indicators button {
    border-radius: 50%;
    width: 10px;
    height: 10px;
    background-color: #fff;
    border: 1px solid #000;
}

.carousel-indicators .active {
    background-color: #000;
}

.carousel-indicators {
    bottom: 0;
    top: auto;
    border-radius: 10px;
}
</style>
