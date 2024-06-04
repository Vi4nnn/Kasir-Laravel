@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Transaction Table -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">{{ $title }}</h6>
                    <button type="button" class="btn text-light" style="background-color: #8E7AB5" data-toggle="modal" data-target="#addNewModal">
                        Add New Transaction
                    </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>No Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Quantity</th>
                                <th>Total Bayar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $transaction->no_transaksi }}</td>
                                    <td>{{ $transaction->tgl_transaksi }}</td>
                                    <td>
                                        @if ($transaction->barang)
                                            {{ $transaction->barang->nama_barang }}
                                        @else
                                            Barang tidak ditemukan
                                        @endif
                                    </td>
                                        <td>
                                            @if ($transaction->barang)
                                                {{ $transaction->barang->harga }}
                                            @endif
                                        </td>
                                        <td>{{ $transaction->quantity }}</td>
                                        <td>{{ $transaction->total_bayar }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#editModal{{ $transaction->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $transaction->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Transaction Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewModalLabel">Add New Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('transaksi.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_transaksi">Transaction Number:</label>
                            <input type="text" name="no_transaksi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_transaksi">Transaction Date:</label>
                            <input type="date" name="tgl_transaksi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="barang_id">Select Item:</label>
                            <select name="barang_id" id="barang_id" class="form-control" onchange="updatePrice()">
                                @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-price="{{ $barang->harga }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga_satuan">Item Price:</label>
                            <input type="number" id="harga_satuan" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_barang">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control"  onchange="calculateTotal()" required>
                        </div>
                        <div class="form-group">
                            <label for="total_bayar">Total Payment:</label>
                            <input type="number" name="total_bayar" id="total_bayar" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-light" style="background-color: #8E7AB5">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($transactions as $transaction)
        <div class="modal fade" id="editModal{{ $transaction->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('transaksi.update', ['id' => $transaction->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="no_transaksi">Transaction Number:</label>
                                <input type="text" name="no_transaksi" class="form-control"
                                    value="{{ $transaction->no_transaksi }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_transaksi">Transaction Date:</label>
                                <input type="date" name="tgl_transaksi" class="form-control"
                                    value="{{ $transaction->tgl_transaksi }}">
                            </div>
                            <div class="form-group">
                                <label for="barang_id">Select Item:</label>
                                <select name="barang_id" id="barang_id_edit{{ $transaction->id }}" class="form-control" onchange="updatePrice('{{ $transaction->id }}')">
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                            {{ $transaction->barang_id == $barang->id ? 'selected' : '' }}
                                            data-price="{{ $barang->harga }}">
                                            {{ $barang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Item Price:</label>
                                <input type="number" id="harga_satuan{{ $transaction->id }}" class="form-control" readonly value="{{ $transaction->barang ? $transaction->barang->harga : 0 }}">
                            </div>
                            <div class="form-group">
                                <label for="jumlah_barang">Quantity:</label>
                                <input type="number" id="jumlah_barang{{ $transaction->id }}" name="jumlah_barang" class="form-control" min="1" value="{{ $transaction->jumlah_barang }}" onchange="calculateTotal('{{ $transaction->id }}')">
                            </div>
                            <div class="form-group">
                                <label for="total_bayar">Total Payment:</label>
                                <input type="number" name="total_bayar" id="total_bayar{{ $transaction->id }}" class="form-control" readonly value="{{ $transaction->total_bayar }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($transactions as $transaction)
        <!-- Delete Transaction Modal -->
        <div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    Are you sure you want to delete this transaction?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('transaksi.destroy', ['id' => $transaction->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function updatePrice(transactionId = null) {
    let selectedItem = null;
    let priceField = null;
    if (transactionId) {
        selectedItem = document.getElementById('barang_id_edit' + transactionId).selectedOptions[0];
        priceField = document.getElementById('harga_satuan' + transactionId);
    } else {
        selectedItem = document.getElementById('barang_id').selectedOptions[0];
        priceField = document.getElementById('harga_satuan');
    }
    let hargaSatuan = selectedItem.getAttribute('data-price');
    priceField.value = hargaSatuan;
    calculateTotal(transactionId);
}

function calculateTotal(transactionId = null) {
    let jumlahField = null;
    let priceField = null;
    let totalField = null;
    if (transactionId) {
        jumlahField = document.getElementById('jumlah_barang' + transactionId);
        priceField = document.getElementById('harga_satuan' + transactionId);
        totalField = document.getElementById('total_bayar' + transactionId);
    } else {
        jumlahField = document.getElementById('jumlah_barang');
        priceField = document.getElementById('harga_satuan');
        totalField = document.getElementById('total_bayar');
    }
    let jumlah = jumlahField.value;
    let hargaSatuan = priceField.value;
    totalField.value = jumlah * hargaSatuan;
}

document.addEventListener('DOMContentLoaded', (event) => {
    updatePrice();
});

</script>
@endsection