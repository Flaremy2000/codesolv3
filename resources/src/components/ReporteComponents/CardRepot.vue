<template>
    <div v-if="listimage.length > 1" class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <!-- Image Carrousel  -->
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div v-for="(content, index) in listimage" :key="content.id_imagereport"
                            :class="['carousel-item', index == 0 ? 'active' : '']">
                            <img :src="'images/incidentes/' + content.imagen" class="d-block" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-8">
                <div
                    :class="['card-header', 'bg-transparent', 'text-center', timeresolved !== 'EN PROCESO' ? 'border-success' : 'border-danger']">
                    <h5 class="card-title">{{ title }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text my-3">{{ description }}
                        <br><br>
                        {{ comentario }}
                    </p>
                </div>
                <div
                    :class="['card-footer', 'bg-transparent', timeresolved !== 'EN PROCESO' ? 'border-success' : 'border-danger']">
                    <p class="card-text"><small class="text-muted">{{ timeresolved }}</small></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Go -->
    <div v-else class="card mb-3" style="max-width: 540px; height: 250px !important;">
        <div
            :class="['card-header', 'bg-transparent', 'text-center', timeresolved !== 'EN PROCESO' ? 'border-success' : 'border-danger']">
            <h5 class="card-title">{{ title }}</h5>
        </div>
        <div class="card-body">
            <p class="card-text">{{ description }}
                <br><br>
                {{ comentario }}
            </p>
        </div>
        <div :class="['card-footer', 'bg-transparent', timeresolved !== 'EN PROCESO' ? 'border-success' : 'border-danger']">
            <p class="card-text"><small class="text-muted">{{ timeresolved }}</small></p>
        </div>
    </div>
    <div class="lightbox-container" style="position: relative;">
        <div class="lightbox">
            <div class="lightbox-content">
                <img src="" alt="" class="lightbox-image">
                <span class="close">&times;</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CardReport",
    props: {
        title: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: true
        },
        listimage: {
            type: Array,
            required: true
        }, timeresolved: {
            type: String,
            required: true
        },
        comentario: {
            type: String,
            required: true
        }
    }, mounted() {
        const carrousel = document.querySelector('.carousel-inner');
        const close = document.querySelector('.close');
        const lightbox = document.querySelector('.lightbox');
        const lightboxImage = document.querySelector('.lightbox-image');

        carrousel.addEventListener('click', (e) => {
            const image = e.target.src;
            lightboxImage.src = image;
            lightbox.style.display = 'flex';
        });

        close.addEventListener('click', () => {
            lightbox.style.display = 'none';
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                lightbox.style.display = 'none';
            }
        });
    }
}
</script>

<style scoped>
.carousel-inner {
    display: flex;
    height: 200px;
}

.carousel-inner img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.carousel-control-next-icon,
.carousel-control-prev-icon {
    background-color: black;
    background-size: 100%, 100%;
    border-radius: 50%;
    height: 50px;
    width: 50px;
    opacity: 0.8;
    filter: alpha(opacity=80);
}

.carousel-control-next-icon:after,
.carousel-control-prev-icon:after {
    font-size: 50px;
    color: white;
}

.carousel-control-prev-icon:hover,
.carousel-control-next-icon:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.carousel-control-next-icon:hover:after,
.carousel-control-prev-icon:hover:after {
    color: white;
}

/* Show up all elements  */
.lightbox-container {
    position: relative;
    z-index: 1130;
}

.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: none;
    justify-content: center;
    align-items: center;
}

.lightbox-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.lightbox-image {
    width: 80%;
    height: auto;
    object-fit: contain;
}

.close {
    color: #fff;
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 3rem;
    font-weight: bold;
    cursor: pointer;
}
</style>
