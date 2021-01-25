<template>
    <div class="container">
        <h1>Legg til ny jobbøsknad</h1>
        <form>
            <div class="form-group">
                <label>Selskap</label>
                <input type="text" class="form-control" v-model="jobapplication.company">
            </div>
            <div class="form-group">
                <label>Stilling</label>
                <input type="text" class="form-control" v-model="jobapplication.jobtitle">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" v-model="jobapplication.status">
                <option>Søknad sendt</option>
                <option>Avslag</option>
                <option>Intervju</option>
                </select>
            </div>
            <div class="form-group">
                <label>Dato søkt</label>
                <input type="date" class="form-control" v-model="jobapplication.date_sent">
            </div>
            <div class="form-group">
                <label>Søknadsfrist</label>
                <input type="date" class="form-control" v-model="jobapplication.date_jobexpired">
            </div>
            <div class="form-group">
                <label>Jobsted</label>
                <input type="text" class="form-control" v-model="jobapplication.place">
            </div>
            <div class="form-group">
                <label>Telefon</label>
                <input type="text" class="form-control" v-model="jobapplication.phone">
            </div>
            <div class="form-group">
                <label>Joblenke</label>
                <input type="text" class="form-control" v-model="jobapplication.applicationlink">
            </div>
            <button type="button" class="btn btn-primary mb-2" v-on:click="postJobapplications()">Legg til søknad</button>
        </form>

    </div>
</template>

<script>

export default {
    data() {
        return {
            jobapplication: {
                company: "",
                jobtitle: "",
                status: "",
                date_sent: "",
                date_jobexpired: "",
                place: "",
                phone: "",
                applicationlink: "",
            }
        }
    },
    
    methods: {
        postJobapplications() {
            fetch('api/jobapplication', {
                method: 'post',
                body: JSON.stringify(this.jobapplication),
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.jobapplication.company = "",
                this.jobapplication.jobtitle = "",
                this.jobapplication.status = "",
                this.jobapplication.date_sent = "",
                this.jobapplication.date_jobexpired = "",
                this.jobapplication.place = "",
                this.jobapplication.phone = "",
                this.jobapplication.applicationlink = "",
                alert('Jobbsøknad lagt til!');
            })
            .catch(err => console.log(err))
        }
    }
}
</script>