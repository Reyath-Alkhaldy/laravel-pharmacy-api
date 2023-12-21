<div class="col-md-6">
    <label for="inputfirstName4" class="form-label">أسم الصيدلية  :</label>
    <x-form.input name="name" placeholder="أسم الصيدلية ..." type="text" id="inputfirstName4" />
</div>
<div class="col-md-6 ">
    <label for="inputlastName3" class="form-label">كلمة المرور :</label>
    <x-form.input name="password"  placeholder="كلمة المرور..." type="password" id="inputfirstName3" />
</div>
<div class="col-md-6 ">
    <label for="inputlastName3" class="form-label">رقم الهاتف :</label>
    <x-form.input name="phone_number" placeholder="رقم الهاتف..." type="number" id="inputfirstName3" />
</div>
<div class="col-md-6 ">
    <label for="inputlastName3" class="form-label">العنوان :</label>
    <x-form.input name="address" placeholder="العنوان..." type="text" id="inputfirstName3" />
</div>
<div class="form-group">
    <label for="" class="form-label">إختيار صورة</label>
    <input type="file" class="form-control" name="logo_image" i accept="image/*"
        aria-describedby="fileHelpId" />
    <div id="fileHelpId" class="form-text">إختار صورةالصيدلية</div>
    <x-input-error :messages="$errors->get('logo_image')" class="mt-2 text-red-600" />
    @if ($pharmacy->image)
        <img src="{{ asset('uploads/' . $pharmacy->image) }}" class="border-t-8 border-blue-600  " style="height: 300px"
            alt="">
    @endif
</div>
<x-form.radio name="status" :checked="$pharmacy->status" :options="['active' => 'Active', 'inactive' => 'Inactive']" />

<div class="col-md-6 ">
    <label for="inputlastName3" class="form-label">عدد الأيام المسموح بها :</label>
    <x-form.input name="number_of_view_days" placeholder="..." type="number" id="inputfirstName3" />
</div>

<div class="col-12  text-center">
    <button type="submit" class="btn btn-primary">{{ $botton_label ?? 'Save' }}</button>
</div>
