<template>
    <div  class="container fontstyle" v-if="isFetched">
        <h1>Jobbsøknader</h1>
        <p>Antall søknader: {{totalJobapplications}}</p>
        <form>
            <div class="form-row">
                <div class="col-auto my-1">
                    <button type="button" class="btn btn-primary router-link"><router-link to="/create" id="card-click">Legg til ny søknad</router-link></button>
                </div>
                <p>Sorter på:</p>
                <div class="my-1 float-right">
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" v-model="userSelectedSorting">
                        <option>Dato sendt</option>
                        <option>Intervju</option>
                        <option>Avslag</option>
                        <option>Sted</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="card mb-3" v-for="jobapplication in jobapplications" v-bind:key="jobapplication.id" :style="jobapplication.status == 'Intervju' ? {'background': '#64FF73'} : jobapplication.status == 'Avslag' ? {'background' : '#EE7676'} : {'background' : '#FFD875'} ">
            <div class="card-body">
                <div class="container">
                    <div class="row mb-3"> <!-- First row -->
                        <div class="col-sm">
                            <h3>Selskap: {{jobapplication.company}}</h3>
                            
                        </div>
                        <div class="col-sm">
                            <h3>Stilling: {{jobapplication.jobtitle}}</h3>
                        </div>
                        <div class="col-sm">
                            <h3>Status: {{jobapplication.status}}</h3>
                        </div>
                    </div>

                    <div class="row mb-3"> <!-- Second row -->
                        <div class="col-sm">
                            Dato sendt: {{jobapplication.date_sent}}
                        </div>
                        <div class="col-sm">
                            Søknadsfrist: {{jobapplication.date_jobexpired}}
                        </div>
                        <div class="col-sm">
                            Sted: {{jobapplication.place}}
                        </div>
                        <div class="col-sm">
                            Telefon: {{jobapplication.phone}}
                        </div>
                    </div>

                    <div class="row"> <!-- Third row -->
                        <div class="col-sm">
                           <a v-bind:href="jobapplication.applicationlink">{{jobapplication.applicationlink}}</a>
                        </div>
                        <div class="col-sm">
                            <span class="float-right"><button type="button" class="btn btn-primary">Endre på søknad</button></span>
                            <span class="float-right mr-3"><button type="button" v-on:click="deleteJobapplication(jobapplication.id)" class="btn btn-danger">Slett søknad</button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                jobapplications: [],
                isFetched: false,
                totalJobapplications: 0,

                userSelectedSorting: "Dato sendt",
                isEdit: false
            }
        },

        created() {
            this.getJobapplications();
        },

        watch: {
            /* Watcher om bruker har sortert 
            userSelectedSorting: function() {
                if (this.userSelectedSorting == "Dato sendt" ) {
                    this.jobapplications.sort((a, b) => (a.applied_date < b.applied_date) ? 1 : -1)
                } 
            },*/
        },

        methods: {
            getJobapplications() {
               fetch('api/jobapplications')
                    .then(res => res.json())
                    .then(res => {
                        this.jobapplications = res.data;
                        this.totalJobapplications = res.meta.total;
                        this.isFetched = true;
                    });
            },
            deleteJobapplication(id) {
                fetch('api/jobapplication/' + id, {
                    method: 'delete'
                })
                .then(data => {
                    alert('Søknad slettet!');
                    this.getJobapplications();
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>

<style scoped>
.fontstyle {
    font-family: Arial, Helvetica, sans-serif;
}

</style>
