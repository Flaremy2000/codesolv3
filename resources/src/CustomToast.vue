<template>
    <div :class="'text-bg-' + variant" class="toast align-items-center border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ message }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true,
        },
        variant: {
            type: String,
            default: 'success',
            validator: (value) => ['success', 'warning', 'error'].includes(value),
        },
        duration: {
            type: Number,
            default: 5000,
        },
    },
    data() {
        return {
            show: false,
        };
    },
    methods: {
        showToast() {
            this.show = true;
            setTimeout(() => {
                this.close();
            }, this.duration);
        },
        close() {
            this.show = false;
        },
    },
    mounted() {
        this.showToast();
    },
};
</script>
