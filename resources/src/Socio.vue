<template>
    <h1 class="mt-5">SOCIOS ACTIVOS</h1>
    <table id="tablemembers" class="table table-hover table-striped" width="100%" ref="myTable">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Manzana</th>
                <th class="text-center">Villa</th>
                <th class="text-center">Nombres</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr v-for="(item, index) in SocioList" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ item.mv.substring(0, 4) }}</td>
                <td>{{ item.mv.substring(4, item.mv.length) == 0 ? 'Villa' : item.mv.substring(4, item.mv.length) }}</td>
                <td>{{ item.name + ' ' + item.lastname }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import DataTable from 'datatables.net-vue3';
import DataTableCore from 'datatables.net-bs5';
import 'datatables.net-responsive';
import 'datatables.net-select';
import $ from 'jquery';
import axios from 'axios'

DataTable.use(DataTableCore);

export default {
    name: "Socio",
    components: {
        DataTable
    },
    data() {
        return {
            SocioList: []
        }
    }, mounted() {
        this.getSocio();
    },
    methods: {
        table() {
            this.$nextTick(() => {
                $("#tablemembers").DataTable({
                    destroy: true,
                })
            })
        },
        getSocio() {
            axios.get('/api/user')
                .then(response => {
                    this.SocioList = response.data
                    this.table()
                })
                .catch(error => {
                    console.log(error)
                })
        }
    },

}
</script>

<style scoped>
h1 {
    padding-top: 15px !important;
}
</style>
