<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectUsersResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group LOYIHALAR
 *
 * Loyihalar uchun API
 */
class ProjectController extends Controller
{
    /**
     * Barcha loyihalar ro'yhati
     */
    public function index()
    {
        $projects = Project::latest()->with('projectOwner')->paginate(20);

        return ProjectResource::collection($projects);
    }

    /**
     * Ma'lum bir id dagi loyihani ko'rsatish
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return new ProjectResource($project);
    }

    /**
     * Yangi loyiha joylash
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create([
            'name' => $request->project_name,
            'project_owner' => $request->project_owner_id,
        ]);

        $project->users()->attach($project->project_owner, ['is_manager' => true]);

        if ($request->users !== null) {
            $users = collect($request->users);

            $project->users()->attach($users);
        }

        return new ProjectResource($project);
    }

    /**
     * Ma'lum bir id dagi loyhani tahrirlash
     */
    public function update(ProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'name' => $request->name,
        ]);

        return new ProjectResource($project);
    }

    /**
     * Ma'lum bir id dagi loyihani ochirish
     */
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();

        return response()->json([
            'data' => 'Deleted Successfully',
        ]);
    }

    /**
     * Ma'lum bir loyihaga foydalanuvchini biriktirish
     *
     * So'rovda project_id va user_id berib yuborish kerak
     */
    public function attachUsertoProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $project->users()->attach($request->user_id);
    }

    /**
     * Ma'lum bir loyihadan foydalanuvchini chiqarib tashlash
     *
     * Bunda project_id berib yuboriladi
     */
    public function getProjectUsers($id)
    {
        $project = Project::findOrFail($id);

        return ProjectUsersResource::collection($project->users);
    }

    /**
     * Ma'lum bir loyihadagi a'zolarni ko'rish
     *
     * Bunda project_id berib yuboriladi
     */
    public function detachUserFromProject($project_id, $user_id)
    {
        $project = Project::findOrFail($project_id);

        $project->users()->detach($user_id);
    }
}
