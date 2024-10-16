<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
@isset($dataDM)
{{ __('Edit Categories') }}
@else
{{ __('List Categories') }}
@endisset

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                <form
                @isset($dataDM)
                action="{{ route('categories.update',$dataDM->MaDM)}}"
                @else
                action="{{ route('categories.store')}}"
             @endisset


                method="POST">
                @csrf
                @isset($dataDM)
                @method('PUT')

                @endisset
                    <div class="w-full flex flex-col py-2">
                        <!-- Row with two columns -->
                        <div class="flex space-x-4">
                            <!-- Column 1: Name -->
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="flex-1">
                                <label for="name" class="text-black font-semibold pb-1 capitalize">Tên danh mục:</label>
                                <input type="text" id="name" class="p-2 border border-[#a5abb5] rounded w-full"
                                @isset($dataDM)
                                   value="{{ $dataDM->TenDM }}"
                                @endisset
                                name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <!-- Column 2: Description -->
                            <div class="flex-1">
                                <label for="description" class="text-black font-semibold pb-1 capitalize">Mô tả:</label>
                                <textarea id="description" class="p-2 border border-[#a5abb5] rounded w-full" name="description" rows="1">
                                @isset($dataDM)
                                   {{ $dataDM->MoTa }}
                                @endisset
                                </textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>


                            </div>
                            <div class="w-full flex justify-end">
                                <input type="submit"
                                    class="hover:text-[#232932]  text-[#efebec] bg-[#0957CB] rounded-lg p-3 text-sm font-semibold btn"


                                    @isset($dataDM)
                                    value=" Chỉnh Sữa"
                                    @else
                                    value="Thêm mới"

                                 @endisset
                                 >
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th> Mã Danh Mục</th>
                                <th>Tên Danh Mục</th>
                                <th>Mô Tả</th>
                                <th>Mã TK</th>
                                <th>Chỉnh Sữa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item )


                            <tr>
                                <td>{{ $item->MaDM }}</td>
                                <td>{{ $item->TenDM }}</td>
                                <td>{{ $item->MoTa }}</td>
                                <td>{{ $item->MaTK }}</td>
                                <td><a href="{{ route('categories.edit',$item->MaDM) }}" class="text-black">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a></td>
                                <td onclick="confirmDelete(event,{{ $item->MaDM }})">
                                    <form id="delete-form-{{ $item->MaDM }}" action="{{ route('categories.destroy', $item->MaDM) }}" method="POST" style="display:inline;" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="border: none; background: none; color: red; cursor: pointer;"  >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


        <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('DataTables/datatables.js') }}"></script>
        <script src="https://kit.fontawesome.com/aa64dc9752.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(event, categoryID) {
                event.preventDefault();

                Swal.fire({
                    title: "Bạn chắc chứ?",
                    text: "Nếu đồng ý sẽ không thể khôi phục! - sẽ xóa luôn các Sản Phẩm của danh mục này !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form nếu người dùng xác nhận
                        document.getElementById(`delete-form-${categoryID}`).submit();
                    }
                });
            }
            </script>
        <script>
            new DataTable('#example');
        </script>
        @if (session('alert'))

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>


            document.addEventListener('DOMContentLoaded', function() {
                const alert = @json(session('alert'));

                Swal.fire({
                    icon: alert.type,
                    title: alert.type === 'error' ? 'Oops!' : 'Success!',
                    text: alert.message,
                    confirmButtonText: 'OK'
                });
            });
        </script>
        @endif
            </div>
        </div>
    </div>
</x-app-layout>
