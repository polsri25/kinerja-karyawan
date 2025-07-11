<!-- resources/views/livewire/penilaian.blade.php -->
<div>
	@if (session()->has('message'))
		<div class="alert alert-warning">
			{{ session('message') }}
		</div>
	@endif
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Penilaian</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div>
				<div class="form-group">
					<label>Periode Penilaian</label>
					<div class="d-flex">
						<input type="date" wire:model="periode_dari" class="form-control mr-2" placeholder="Dari">
						<span class="mx-2 align-self-center">sampai</span>
						<input type="date" wire:model="periode_sampai" class="form-control" placeholder="Sampai">
					</div>
					@error('periode_dari')
						<span class="text-danger">{{ $message }}</span>
					@enderror
					@error('periode_sampai')
						<span class="text-danger">{{ $message }}</span>
					@enderror
				</div>
				<div class="form-group">
					<label>Pilih Jabatan</label>
					<select wire:model="selectedJabatan" wire:change="jabatanChanged($event.target.value)" class="form-control">
						<option value="">Pilih Jabatan</option>
						@foreach ($jabatans as $jabatan)
							<option value="{{ $jabatan }}">{{ $jabatan }}</option>
						@endforeach
					</select>
				</div>

				@if (!empty($karyawanByJabatan))
					<div class="form-group">
						<label>Pilih Karyawan</label>
						<select wire:model="selectedKaryawan" class="form-control">
							<option value="">Pilih Karyawan</option>
							@foreach ($karyawanByJabatan as $karyawan)
								<option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
							@endforeach
						</select>
					</div>
				@endif

				<div class="text-right">
					<button wire:click="tambahKaryawan" class="btn btn-block btn-outline-success" style="width: 20%">Tambah
						Pegawai</button>
				</div>
				<hr>
			</div>



			@foreach ($selectedKaryawanList as $karyawan)
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" class="form-control" value="{{ $karyawan['nama'] }}">
						</div>
					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<label>Jabatan</label>
							<input type="text" class="form-control" value="{{ $karyawan['jabatan'] }}">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>NIM</label>
							<input type="text" class="form-control" value="{{ $karyawan['nim'] }}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Alamat</label>
							<textarea class="form-control">{{ $karyawan['alamat'] }}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					@foreach ($kriteria as $item)
						<div class="col-sm-3">
							<div class="form-group">
								<label>{{ $item->nama }}</label>
								<input type="number" class="form-control"
									wire:model="nilai.{{ $karyawan['id'] }}.{{ $item->id }}.{{ $item->nama }}">
								@error('nilai.' . $karyawan['id'] . '.' . $item->id . '.' . $item->nama)
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
					@endforeach
				</div>
				<hr>
			@endforeach


			<div class="text-right">
				<a wire:click="hasilAkhir" class="btn btn-outline-warning"
					style="width: 20%; background-color: #f39c12; color: white;">
					Simpan
				</a>
			</div>
		</div>
		<!-- /.card-body -->
	</div>
</div>
