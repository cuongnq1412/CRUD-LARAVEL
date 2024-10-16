<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
@isset($dataSP)
{{ __('Edit Products') }}
@else
{{ __('List Products') }}
@endisset

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                <form
                @isset($dataSP)
                action="{{ route('products.update',$dataSP->MaSP)}}"
                @else
                action="{{ route('products.store')}}"
             @endisset


                method="POST" enctype="multipart/form-data">
                @csrf
                @isset($dataSP)
                @method('PUT')

                @endisset




                            <!-- Column 1: Name -->
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">


                            <div class="w-full flex flex-row py-2 space-x-4">

                            <div class="w-1/2 flex flex-col py-2">
                                <label for="m_sp" class="text-black font-semibold pb-1 capitalize">Mã SP:</label>
                                <input type="text" id="m_sp" class="p-2 border border-[#a5abb5] rounded w-full"

                                @isset($dataSP)
                                    value="{{ $dataSP->MaSP }}"
                                @endisset
                                name="m_sp">
                                <x-input-error :messages="$errors->get('m_sp')" class="mt-2" />
                            </div>

                            <div class="w-1/2 flex flex-col py-2">
                                <label for="ten_sp" class="text-black font-semibold pb-1 capitalize">Ten SP:</label>
                                <input type="text" id="ten_sp" class="p-2 border border-[#a5abb5] rounded w-full"
                                @isset($dataSP)
                                value="{{ $dataSP->TenSP }}"
                            @endisset
                                name="ten_sp">
                                <x-input-error :messages="$errors->get('ten_sp')" class="mt-2" />
                            </div>
                            </div>
                            <div class="w-full flex flex-col py-2">
                                <label for="price" class="text-black font-semibold pb-1 capitalize">Gia SP:</label>
                                <input type="number" id="price" class="p-2 border border-[#a5abb5] rounded w-full"
                                @isset($dataSP)
                                value="{{ $dataSP->DonGia }}"
                            @endisset
                                name="price">
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div class="w-full flex flex-col py-2">
                                <label for="mota" class="text-black font-semibold pb-1 capitalize">Mo Ta:</label>
                                <textarea type="number" id="mota" class="p-2 border border-[#a5abb5] rounded w-full"

                                name="mota">
                                @isset($dataSP)
                              {{ $dataSP->MoTa }}
                            @endisset
                            </textarea>
                                <x-input-error :messages="$errors->get('mota')" class="mt-2" />
                            </div>
                            <div class="w-full flex flex-col py-2">
                                <label for="danhmuc" class="text-black font-semibold pb-1 capitalize">Danh Mục:</label>
                                <select id="danhmuc" name="danhmuc" class="p-2 border border-[#a5abb5] rounded" required>

                                    @isset($dataSP)
                                    @foreach ($danhmuc as $item )
                                    <option value="{{ $item->MaDM }}"  {{ $item->MaDM == old('danhmuc',$dataSP->MaSP ? 'selected' : '' ) }} >{{ $item->TenDM }}</option>
                                    @endforeach
                                    @else
                                    @foreach ($danhmuc as $item )
                                    <option value="{{ $item->MaDM }}">{{ $item->TenDM }}</option>

                                    @endforeach
                                    @endisset

                                </select>

                            </div>



                            <div class="w-full flex flex-col py-2 mt-10">
                                <label for="product_photo" class="text-black   font-semibold pb-1 capitalize"> <i
                                        class="fa-solid fa-file-image fa-2xl"></i> Tải lên ảnh Sp </label>
                                <input type="file" class="product_photo" name="product_photo" id="product_photo"
                                    class="p-2  hidden border border-[#E8F0FC] rounded" style="display:none">

                                    @isset($dataSP)
                                    <img id="preview_img" class="mt-4  border border-gray-300 rounded" src="{{ asset($dataSP->HinhAnh) }}" style="width: 100px; height: auto;">
                                    @endisset
                                      <img id="preview_img" class="mt-4 hidden  border border-gray-300 rounded"  style="width: 100px; height: auto;">
                                      <x-input-error :messages="$errors->get('product_photo')" class="mt-2" />
                                </div>

                            <div class="w-full flex justify-end">
                                <input type="submit"
                                    class="hover:text-[#232932]  text-[#efebec] bg-[#0957CB] rounded-lg p-3 text-sm font-semibold btn"


                                    @isset($dataSP)
                                    value=" Chỉnh Sữa"
                                    @else
                                    value="Thêm mới"

                                 @endisset
                                 >
                                </form>
                        </div>
                    {{-- </div> --}}
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
                                <th> Mã Sản Phẩm </th>
                                <th>Tên Sản Phẩm</th>
                                <th>Mô Tả</th>
                                <th>Giá</th>
                                <th>Hình Ảnh</th>
                                <th>Chỉnh Sữa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item )


                            <tr>
                                <td>{{ $item->MaSP }}</td>
                                <td>{{ $item->TenSP }}</td>
                                <td>{{ $item->MoTa }}</td>
                                <td>{{ $item->DonGia }}</td>
                                <td>
                                    <img src="{{ asset($item->HinhAnh) }}" width="100px">
                                </td>
                                <td><a href="{{ route('products.edit',$item->MaSP) }}" class="text-black">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a></td>
                                <td >
                                    <form id="delete-form-{{ $item->MaSP }}" action="{{ route('products.destroy', $item->MaSP) }}" method="POST" style="display:inline;" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  style="border: none; background: none; color: red; cursor: pointer;"  >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


        <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('DataTables/datatables.js') }}"></script>
        <script src="https://kit.fontawesome.com/aa64dc9752.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- <script>
            function confirmDelete(event,product) {
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
                        document.getElementById(`delete-form-${product}`).submit();
                    }
                });
            }
            </script> --}}
        <script>
            new DataTable('#example');
        </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('product_photo');
        const previewImg = document.getElementById('preview_img');

        input.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                };

                reader.readAsDataURL(file);
            } else {
                previewImg.classList.add('hidden');
            }
        });
    });
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
