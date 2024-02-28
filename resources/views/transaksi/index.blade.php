@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Transaction Table -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addNewModal">
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
                                <th>Diskon</th>
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
                                    <td>{{ $transaction->diskon }}</td>
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
                            <label for="total_bayar">Total Payment:</label>
                            <input type="number" name="total_bayar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="diskon">Discount:</label>
                            <input type="number" name="diskon" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($transactions as $transaction)
        {{-- Edit Transaction Modal --}}
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
                            <input type="text" name="no_transaksi" class="form-control" value="{{ $transaction->no_transaksi }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_transaksi">Transaction Date:</label>
                            <input type="date" name="tgl_transaksi" class="form-control" value="{{ $transaction->tgl_transaksi }}">
                        </div>
                        <div class="form-group">
                            <label for="total_bayar">Total Payment:</label>
                            <input type="number" name="total_bayar" class="form-control" value="{{ $transaction->total_bayar }}">
                        </div>
                        <div class="form-group">
                            <label for="diskon">Discount:</label>
                            <input type="number" name="diskon" class="form-control" value="{{ $transaction->diskon }}">
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
@endsection
