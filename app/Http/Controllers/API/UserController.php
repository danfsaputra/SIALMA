<?php

namespace App\Http\Controllers\API;

// use App\Models\Pegawaikab;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersStoreRequest as StoreRequest;
use App\Models\OPD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = User::withTrashed()->when($search, function ($query) use ($search) {
            $query->where('name', 'ilike', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(StoreRequest $request)
    {
        $user = $request->user();
        $password = $request->id ? $user->password : Hash::make('AkunSatpol');

        $opd = OPD::whereId($request->id)->first();

        $post_data = array_merge($request->all(), [
            "id" => $opd->id,
            "name" => $opd->numfmt_parse,
            "email" => str_replace(" ", "", $opd->email),
            "password" => $password,
        ]);

        User::updateOrCreate(['id' => $request->id], $post_data);

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !"]);
    }

    public function reset($id)
    {
        User::whereId($id)->update(['password' => Hash::make('AkunSatpol')]);

        return response()->json(["success" => true, "message" => "Password berhasil direset ke default : <br><br><b>AkunSatpol</b>"]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ], [
            'password.required'              => 'Mohon isikan password baru anda',
            'password.confirmed'             => 'Password konfirmasi dan password baru tidak cocok',
            'password.min'                   => 'Password minimal 8 digit dengan kombinasi huruf dan angka',
            'password_confirmation.required' => 'Password konfirmasi harus sama dengan password baru'
        ]);

        User::whereId($user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => true, 'message' => "Password berhasil diperbarui.<br>Silakan melakukan login ulang"]);
    }

    public function activate($id)
    {
        User::whereId($id)->restore();

        return response()->json(["success" => true, "message" => "Berhasil mengaktifkan akun !"]);
    }

    public function destroy($id)
    {
        User::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menon-aktifkan akun !"]);
    }
}
