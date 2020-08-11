<template>
  <t-card 
    :header="$t('USER MANAGEMENT')" 
    class="container">
       <t-input-group>
        <t-button 
          type="submit"
          variant="primary" href="addUser"
        >{{ $t('ADD') }}</t-button>

     
      </t-input-group>
        <table class="table-fixed">
          
        <thead>
            <tr>
            <th class="border w-1/8 px-4 py-2">ID</th>
            <th class="border w-1/4 px-4 py-2">Name</th>
            <th class="border w-1/4 px-4 py-2">Email</th>
              <th class="border w-1/2 px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr   v-for="item in posts" v-bind:key="item.key">
            <td class="border px-4 py-2">{{item.id}}</td>
            <td class="border px-4 py-2">{{item.name}}</td>
            <td class="border px-4 py-2">{{item.email}}</td>
             <td class="border px-4 py-2">

            <t-button 
                type="submit"
                variant="success" class="btn-sm" @click="updateUser(item.id)"
                >{{ $t('UPDATE') }}
            </t-button>

              <t-button 
                type="button"
                variant="danger"  @click="deleteUser(item.id)"
                >{{ $t('DELETE') }}
            </t-button>

                  
             </td>
            </tr>
           
        </tbody>
        </table>

  </t-card>

  
</template>



<script>
import Form from 'vform'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  head () {
    return { title: this.$t('settings') }
  },

  data () {
    return {
      allPost: [],
      posts: []
    }
  },

  

   mounted () {

    axios(process.env.apiUrl+'/settings/user', {
      crossDomain: true
    }).then( ({ data }) => {
      this.allPost = data.data
      console.log(data.data)
      data.data.map((item, key) => {
        if (item.name !== null && this.posts.length < 9) {
          this.posts.push(item)
        }
      })
    })
  },


  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async update () {
      this.form.patch('/settings/profile')
        .then(({ data }) => {
          this.$store.dispatch('auth/updateUser', { user: data })
        })
    },

    updateUser(id) {
         window.location ='editUser/'+id;
    },

    deleteUser(id) {
        axios(process.env.apiUrl+'/settings/deleteUser/'+id, {
            crossDomain: true
            }).then( ({ data }) => {
            window.location ='user_management';
        })
    },
  }
}
</script>
