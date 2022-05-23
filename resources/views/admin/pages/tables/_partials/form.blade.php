@include('admin.includes.alerts')

<div class="form-group">
    <label>Identificador</label>
    <input type="text" name="identify" class="form-control" placeholder="Nome" value="{{ $table->identify ?? old('name') }}">
</div>
<div class="form-group">
    <label>Descrição</label>
    <input type="text" name="description" class="form-control" placeholder="Descrição" value="{{ $table->description ?? old('description') }}">
</div>
<div class="form-group">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>
