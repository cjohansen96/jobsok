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
                        <option>Standard</option>
                        <option>Dato sendt</option>
                        <option>Selskap</option>
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
                            <h3><span class="first-word">Selskap:</span> {{jobapplication.company}}</h3>
                            
                        </div>
                        <div class="col-sm">
                            <h3><span class="first-word">Stilling:</span> {{jobapplication.jobtitle}}</h3>
                        </div>
                        <div class="col-sm">
                            <h3><span class="first-word">Status:</span> {{jobapplication.status}}</h3>
                        </div>
                    </div>

                    <div class="row mb-3"> <!-- Second row -->
                        <div class="col-sm">
                            <span class="first-word">Dato sendt:</span> {{jobapplication.date_sent}}
                        </div>
                        <div class="col-sm">
                            <span class="first-word">Søknadsfrist:</span> {{jobapplication.date_jobexpired}}
                        </div>
                        <div class="col-sm">
                            <span class="first-word">Sted:</span> {{jobapplication.place}}
                        </div>
                        <div class="col-sm">
                            <span class="first-word">Telefon:</span> {{jobapplication.phone}}
                        </div>
                    </div>

                    <div class="row"> <!-- Third row -->
                        <div class="col-sm">
                           <a v-bind:href="jobapplication.applicationlink">{{jobapplication.applicationlink}}</a>
                        </div>
                        <div class="col-sm">
                            <span class="float-right"><button type="button" class="btn btn-primary border border-secondary"><router-link v-bind:to="'/update/' + jobapplication.id" id="card-click">Endre på søknad</router-link></button></span>
                            <span class="float-right mr-3"><button  type="button" class="btn btn-danger border border-secondary" v-on:click="deleteJobapplication(jobapplication.id)">Slett søknad</button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example"> <!-- Pagination -->
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getJobapplications(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Side {{pagination.current_page}} av {{pagination.last_page}}</a></li>
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

                userSelectedSorting: "Standard",
            }
        },

        created() {
           this.getJobapplications();
        },

        watch: {
            userSelectedSorting: function() {
                if (this.userSelectedSorting == "Standard" ) {
                    this.getJobapplications();
                } 
                else if(this.userSelectedSorting == "Dato sendt") {
                    this.getJobapplications("api/jobapplications/date_sent");
                }
                else if(this.userSelectedSorting == "Selskap") {
                    this.getJobapplications("api/jobapplications/company");
                }
                else if(this.userSelectedSorting == "Sted") {
                    this.getJobapplications("api/jobapplications/place");
                }
            },
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
                if(confirm('Er du sikker?')) {
                    fetch('api/jobapplication/' + id, {
                        method: 'delete'
                    })
                    .then(data => {
                        alert('Jobbsøknad slettet!');
                        this.getJobapplications();
                    })
                    .catch(err => console.log(err))
                }
            }
        }
    }
</script>

<style scoped>
.fontstyle {
    font-family: Arial, Helvetica, sans-serif;
}
.first-word {
    text-decoration: underline;
    font-weight: 600;
    font-style: italic;
}

</style>
