@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-md-10">
		<h2 class="titlePage">{{ __('CONTACT') }}</h2>
	</div>
	
	@if(session('message'))
	<div class='alert alert-success'>
		{{ session('message') }}
	</div>
	@endif
	
	<div class="col-12 col-md-10">
		<form class="form-horizontal" method="POST" action="/contact">
		<div class="row">
			<div class="col">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="Name">Nom: </label>
					<input type="text" class="form-control" id="name" placeholder="Votre nom" name="name" required>
				</div>

				<div class="form-group">
					<label for="fname">Prénom: </label>
					<input type="text" class="form-control" id="fname" placeholder="Votre prénom" name="fname" required>
				</div>
				<div class="form-group">
					<label for="email">Prénom: </label>
					<input type="email" class="form-control" id="email" placeholder="john@example.com" name="email" required>
				</div>

				<div class="form-group">
					<label for="phone">Prénom: </label>
					<input type="tel" class="form-control" id="phone" placeholder="0148020411" name="phone" required>
				</div>
			</div>
			<div class="col">
				<label for="fname">Motif: </label>
				<select class=form-control>
					<option value=un>Réclamation</option>
					<option value=deux>Suggestion / FAQ</option>
					<option value=trois>Demande d'information</option>
				</select>
				<div class="form-group">
					<label for="message">Message: </label>
					<textarea type="text" class="form-control luna-message" id="message" placeholder="Votre message" name="message" required rows="9"></textarea>
				</div>

			</div>
		</div>



			<div class="form-group">
				<button type="submit" class="btn btn-primary" value="Envoyer">ENVOYER</button>
			</div>
		</form>
	</div>
 </div> <!-- /container -->
@endsection