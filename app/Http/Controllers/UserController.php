<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CreateUserRequest;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;

    class UserController extends Controller
    {

        public function getUsers(Request $request): JsonResponse
        {
            $page = $request->input("per_page", 10);
            $users = User::paginate($page);
            return response()->json([
                'users' => UserResource::collection($users->items()),
                'pagination' => [
                    'total' => $users->total(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ],
            ]);
        }


        public function getUser(int $id): JsonResponse
        {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            return response()->json([
                'user' => new UserResource($user),
            ]);
        }

        public function storeOrUpdateUser(CreateUserRequest $request, ?int $id = null): JsonResponse
        {
            if ($id !== null) {
                $user = User::findOrFail($id);
                $user->update($this->extractData($request, $user));
            } else {
                $user = User::create($this->extractData($request, new User()));
            }
            return response()->json([
                "user" => new UserResource($user)
            ]);
        }

        public function extractData(CreateUserRequest $request, ?User $user = null): array
        {
            $imagePath = 'chemin/vers/votre/image/' . $imageName;

    // Vérifier si l'image existe
    if (Storage::exists($imagePath)) {
        // Renvoyer l'image avec le bon type de contenu
        $fileContents = Storage::get($imagePath);
        $response = response()->make($fileContents, 200);
        $response->header('Content-Type', Storage::mimeType($imagePath));
        return $response;
    } else {
        // Gérer le cas où l'image n'existe pas
        return response()->json(['message' => 'Image not found'], 404);
    }

            return $data;
        }


        public function destroy(int $id): JsonResponse
        {
            $user = User::find($id);
            $res = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            if ($user->image) {
                Storage::disk("public")->delete($user->image);
            }

            $user->delete();

            return response()->json([
                'user' => new UserResource($res),
            ]);
        }
    }
