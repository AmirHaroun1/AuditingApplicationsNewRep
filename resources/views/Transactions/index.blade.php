@extends('Layout')

@section('title')
    @if(auth()->user()->role == 'سكرتير')
        سكرتير - المعاملات

    @elseif(auth()->user()->role == 'مراجع فنى')
        مراجع فنى - المعاملات
    @elseif(auth()->user()->role == 'مدقق')
        مدقق - المعاملات
    @elseif(auth()->user()->role == 'مدير مراجعة')
        مدير مراجعة - المعاملات
    @elseif(auth()->user()->role == 'سكرتير تنفيذي')
        سكرتير تنفيذي - المعاملات
    @endif
@endsection

@section('PageHeader')
    @if(auth()->user()->role == 'سكرتير')
        سكرتير - المعاملات

        @elseif(auth()->user()->role == 'مراجع فنى')
            مراجع فنى - المعاملات
        @elseif(auth()->user()->role == 'مدقق')
            مدقق - المعاملات
        @elseif(auth()->user()->role == 'مدير مراجعة')
            مدير مراجعة - المعاملات
        @elseif(auth()->user()->role == 'سكرتير تنفيذي')
            سكرتير تنفيذي - المعاملات
    @endif
@endsection
@section('content')
                    @if(auth()->user()->role == 'سكرتير')
                        <secretary-transactions-table auth="{{$AuthUser}}"></secretary-transactions-table>
                        @elseif(auth()->user()->role == 'مراجع فني')
                        <reviser-transactions-table auth="{{$AuthUser}}"></reviser-transactions-table>
                        @elseif(auth()->user()->role == 'مدقق')
                        <auditor-transactions-table auth="{{$AuthUser}}"></auditor-transactions-table>
                        @elseif(auth()->user()->role == 'مدير مراجعة')
<<<<<<< HEAD
                        <revising-manager-transactions-table auth="{{$AuthUser}}"></revising-manager-transactions-table>
=======
                        <revising-manager-transactions-table auth="{{json_encode(auth()->user())}}"></revising-manager-transactions-table>
>>>>>>> 65d1016eb2f45e0103e16fe7f569f246e7fcb5dd
                        @elseif(auth()->user()->role == 'شريك اداري')
                        <partner-transactions-table auth="{{$AuthUser}}"></partner-transactions-table>
                        @elseif(auth()->user()->role == 'سكرتير تنفيذي')
                        <archive-transactions-table auth="{{$AuthUser}}"></archive-transactions-table>
                    @endif
@endsection
@section('scripts')

            <script src="{{ asset('js/app.js')}}"></script>

@endsection
