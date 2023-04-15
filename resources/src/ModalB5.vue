<template>
    <!-- Modal -->
    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="close"></button>
                </div>
                <div class="modal-body">
                    <form ref="form">
                        <div v-for="(field, index) in fields" :key="index"
                            :class="{ 'form-floating': field.floating, 'mb-3': true }">
                            <label v-if="field.type === null" class="h3 mb-3">{{ field.label }}</label>
                            <select v-if="field.type === 'select'" class="form-control" :name="field.name" :id="field.name"
                                :value="field.value">
                                <option v-for="(option, optionIndex) in field.options" :key="optionIndex"
                                    :value="option.value">{{ option.label }}</option>
                            </select>
                            <label v-if="!field.floating && field.label !== '' && field.type !== null" :for="field.name"
                                class="form-label">{{ field.label }}</label>
                            <input v-if="!field.btn && field.type !== null && field.type !== 'select'" :type="field.type"
                                class="form-control" :name="field.name" :id="field.name" :placeholder="field.placeholder"
                                :value="field.value">

                            <label v-if="field.floating && field.label !== '' && field.type !== null" :for="field.name"
                                class="form-label">{{ field.label }}</label>
                            <button v-if="field.btn" type="button" class="btn btn-primary" @click="customfunction">
                                {{ field.name }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ModalB5',
    props: {
        title: {
            type: String,
            default: 'Modal Title'
        },
        ejectfunction: {
            type: Function,
            default: null
        },
        fields: {
            type: Array,
            default: () => []
        },
    },
    methods: {
        close() {
            this.$emit('close');
        },
        customfunction() {
            if (this.ejectfunction) {
                const formdata = new FormData(this.$refs.form);
                // for (let entry of formdata.entries()) {
                //     console.log(entry[0] + ': ' + entry[1]);
                // }
                this.ejectfunction(formdata);
            }
            this.$emit('save');
        }
    }
}
</script>
<style scoped>
.modal {
    display: none;
    background: rgba(0, 0, 0, 0.5);
}

.modal.show {
    display: block;
}

.modal-dialog {
    margin: 10vh auto;
    max-width: 500px;
}

.modal-content {
    border-radius: 0.25rem;
}

.modal-header {
    border-bottom: none;
}

.modal-footer {
    border-top: none;
}
</style>
