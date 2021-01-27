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
                            <span class="float-right"><button type="button" class="btn btn-primary border border-secondary">Endre på søknad</button></span>
                            <span class="float-right mr-3"><button  type="button" class="btn btn-danger border border-secondary" v-on:click="deleteJobapplication(jobapplication.id)">Slett søknad</button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example"> <!-- Pagination -->
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getJobapplications(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getJobapplications(pagination.next_page_url)">Next</a></li>
            </ul>
       </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                jobapplications: [],
                isFetched: false,
                totalJobapplications: 0,
                pageination: {},

                userSelectedSorting: "Dato sendt",
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
            getJobapplications(page_url) {
                let vm = this;
                page_url = page_url || 'api/jobapplications'
               fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.jobapplications = res.data;
                        this.totalJobapplications = res.meta.total;
                        this.isFetched = true;
                        vm.makePageination(res.meta, res.links)
                        console.log(res);
                    })
                    .catch(err => console.log(err));
            },
            makePageination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
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
