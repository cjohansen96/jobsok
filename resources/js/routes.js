import Jobapplications from './components/Jobapplications'
import CreateJobapplication from './components/CreateJobapplication'

export default [
    {
        path: '/',
        component: Jobapplications
    },
    {
        path: '/create',
        component: CreateJobapplication
    },
]