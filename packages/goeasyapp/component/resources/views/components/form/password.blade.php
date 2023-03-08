<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{ __trans($language, $key, $default) }}</label>
   
    <div class="input-group auth-pass-inputgroup">
        <input type="password" class="form-control" placeholder="{{ __trans($language, $placeholder, $defaultplaceholder) }}" name="{{$name}}" value="{{$value}}"/>
        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
    </div>
</div>