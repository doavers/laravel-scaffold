<template>
	<div class="card">
      <div class="card-header">
        <i class="fas fa-pencil-alt"></i> Contact Form
      </div>
      <div class="card-body">
		<form class="form-horizontal needs-validation" novalidate @submit.prevent="send" method="post" action="/send">

			<div v-if="success" class="alert alert-success">
				Terima kasih. Pesan berhasil dikirim.
			</div>

			<div class="form-group">
				<label>Nama Lengkap</label>
				<input v-model="state.name" type="text" name="name" class="form-control" :class="{'is-invalid': errors.name}">
				<span class="label label-danger">{{ error(errors.name) }}</span>
				<div class="invalid-feedback" v-if="errors.name">{{ error(errors.name) }}</div>
			</div>

			<div class="form-group">
				<label>Email</label>
				<input v-model="state.email" type="email" name="email" class="form-control" :class="{'is-invalid': errors.email}">
				<span class="label label-danger">{{ error(errors.email) }}</span>
				<div class="invalid-feedback" v-if="errors.email">
		          	{{ error(errors.email) }}
		        </div>
			</div>

			<div class="form-group">
				<label>Pesan</label>
				<textarea v-model="state.message" name="message" class="form-control"></textarea>
				<span class="label label-danger">{{ error(errors.message) }}</span>
				<div class="invalid-feedback" v-if="errors.message">
		          	{{ error(errors.message) }}
		        </div>
			</div>

			<div class="form-group">
				<button class="btn btn-primary" type="submit">
					Kirim Pesan
				</button>
			</div>
			
		</form>
	  </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				success: false,
				errors: [],
				state: {
					name: '',
					email: '',
					message: ''
				}
			}
		},
		methods: {
			send(e) {
				axios.post(e.target.action, this.state).then(response => {
					this.success = response.data.success;
					
					if(response.data.success == true) {
						this.errors = [];
						this.state = {
							name: '',
							email: '',
							message: ''
						}
					}
				}).catch(error => {
					console.log(error);
					console.log(error.response);
					if (error.response.status == 422) {
						this.errors = error.response.data.errors;
						this.$toasted.global.error(error.response.data.message);
						console.log(this.error);
					}
				})
			},
			error(field) {
				return _.head(field);
			}
		}
	}
</script>