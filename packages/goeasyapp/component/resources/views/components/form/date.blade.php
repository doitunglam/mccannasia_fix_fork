<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{ __trans($language, $key, $default) }}</label>
    <div class="input-group" id="datepicker1">
        <input type="text" class="form-control" name="{{$name}}" value="{{$value}}" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1" data-provide="datepicker">
        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
</div>
@push('c-script')
<script>
	
</script>
@endpush