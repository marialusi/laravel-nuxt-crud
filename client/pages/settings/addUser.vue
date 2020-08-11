<template>
  <t-card 
    :header="$t('USER MANAGEMENT')" 
    class="w-full">
    <form 
      class="max-w-md w-full"
      @submit.prevent="register" 
      @keydown="form.onKeydown($event)">
      <t-card 
        :header="$t('ADD USER')" 
        class="shadow-sm"
      >
        <t-input-group
          :label="$t('name')"
          :status="form.errors.has('name') ? false : null"
          :feedback="form.errors.get('name')"
        >
          <t-input
            :disabled="form.busy"
            v-model="form.name"
            :status="form.errors.has('name') ? false : null"
            type="name"
            name="name"
            class="w-full"
          />
        </t-input-group>
        <t-input-group
          :label="$t('email')"
          :status="form.errors.has('email') ? false : null"
          :feedback="form.errors.get('email')"
        >
          <t-input
            :disabled="form.busy"
            v-model="form.email"
            :status="form.errors.has('email') ? false : null"
            type="email"
            name="email"
            autocomplete="username"
            class="w-full"
          />
        </t-input-group>
          <t-input-group
          :label="$t('password')"
          :status="form.errors.has('password') ? false : null"
          :feedback="form.errors.get('password')"
        >
          <t-input
            :disabled="form.busy"
            v-model="form.password"
            :status="form.errors.has('password') ? false : null"
            type="password"
            name="password"
            autocomplete="new-password"
            class="w-full"
          />
        </t-input-group>
      
      
        <t-input-group>
          <t-button 
            :disabled="form.busy"
            type="submit" 
            variant="primary"
          >
            <template v-if="form.busy">...</template>
            <template v-else>{{ $t('ADD') }}</template>
          </t-button>
          <t-button   variant="warning" href="user_management">{{ $t('Cancel') }}</t-button>
          <login-with-github/>
        </t-input-group>
      </t-card>
    </form>
  </t-card>
</template>

<script>
import Form from 'vform'

export default {
  head () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      role:'admin'
    })
  }),

  methods: {
    async register () {
      try {
      // Register the user.
        const { data } = await this.form.post('/settings/createUser')

        // Redirect home.
        this.$router.push({ name: 'settings.user_management' })
      } catch (e) {
        if (e.response.status !== 422) {
          throw e
        }
      }
    }
  }
}
</script>
