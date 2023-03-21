<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{ __trans($language, $key, $default) }}</label>
    <input type="number" class="form-control" id="{{$id}}" placeholder="{{ __trans($language, $placeholder, $defaultplaceholder) }}"  name="{{$name}}" value="{{$value}}" />

</div>
