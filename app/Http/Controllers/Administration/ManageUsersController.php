<?php

namespace App\Http\Controllers\Administration;

use App\Models\ModerationActivity;
use App\Models\Trade;
use App\Models\User;
use App\Notifications\Authentication\UserActivated;
use App\Notifications\Authentication\UserDeactivated;
use App\Notifications\Authentication\UserForceDeleted;
use App\Notifications\Authentication\UserRestored;
use App\Notifications\Authentication\UserSoftDeleted;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class ManageUsersController extends Controller
{
    /**
     * Filter users with role
     *
     * @var string
     */
    private $role;

    /**
     * Hide/Show deleted users
     *
     * @var string
     */
    private $deleted;

    /**
     * Filter users with status
     *
     * @var string
     */
    private $status;

    /**
     * ManageUsersController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->role = $request->get('role');
        $this->deleted = $request->get('deleted');
        $this->status = $request->get('status');
    }

    /**
     * Show index page of Manage Users' Menu
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $showTrashed = $this->deleted == 'true';

        if ($showTrashed) {
            $roles = Role::withCount(['users' => function ($query) {
                $query->whereNotNull('deleted_at');
            }])->get();

            $users_count = User::onlyTrashed()
                ->select(DB::raw('COUNT(*) as total, status'))
                ->groupBy('status')->get();

        } else {
            $roles = Role::withCount('users')->get();

            $users_count = User::select(DB::raw('COUNT(*) as total, status'))
                ->groupBy('status')->get();
        }

        return view('administration.manage_users.index')
            ->with(compact('roles', 'users_count'))
            ->with(compact('showTrashed'));
    }

    /**
     * Activate user account
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        if ($request->ajax()) {
            if ($user = User::where('name', $request->name)->first()) {
                $user->status = 'active';
                $user->save();

                $user->moderation_activities()->create([
                    'activity' => 'Activated User',
                    'moderator' => Auth::user()->name,
                    'comment' => $request->prompt
                ]);

                return response(__("The user has been activated successfully!"));

            } else {
                return response(__("The user could not be found!"), 404);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * Deactivate user account
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        if ($request->ajax()) {
            if ($user = User::where('name', $request->name)->first()) {

                $trades = Trade::whereIn('status', ['active', 'dispute'])
                    ->where(function ($query) use($user) {
                        $query->where('partner_id', $user->id);
                        $query->orWhere('user_id', $user->id);
                    });

                if(!$trades->count()){
                    $user->status = 'inactive';
                    $user->save();

                    $user->moderation_activities()->create([
                        'activity' => 'Deactivated User',
                        'moderator' => Auth::user()->name,
                        'comment' => $request->prompt
                    ]);

                    $user->notify(new UserDeactivated());

                    return response(__("The user has been deactivated successfully!"));
                }else{
                    return response(__("The user currently has ongoing trades!"), 403);
                }

            } else {
                return response(__("The user could not be found!"), 404);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * Soft delete user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($user = User::where('name', $request->name)->first()) {

                    $trades = Trade::whereIn('status', ['active', 'dispute'])
                        ->where(function ($query) use($user) {
                            $query->where('partner_id', $user->id);
                            $query->orWhere('user_id', $user->id);
                        });

                    if(!$trades->count()){
                        $user->notify(new UserSoftDeleted());

                        $user->moderation_activities()->create([
                            'activity' => 'Soft Deleted User',
                            'moderator' => Auth::user()->name,
                            'comment' => $request->prompt
                        ]);

                        $user->delete();

                        return response(__("The user has been deleted successfully!"));
                    }else{
                        return response(__("The user currently has ongoing trades!"), 403);
                    }

                } else {
                    return response(__("The user could not be found!"), 404);
                }
            } catch (\Exception $e) {
                return response($e->getMessage(), 404);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * Soft delete user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($user = User::onlyTrashed()->where('name', $request->name)->first()) {

                    $user->restore();

                    $user->moderation_activities()->create([
                        'activity' => 'Restored User',
                        'moderator' => Auth::user()->name,
                        'comment' => $request->prompt
                    ]);

                    $user->notify(new UserRestored());

                    return response(__("The user has been restored successfully!"));

                } else {
                    return response(__("The user could not be found!"), 404);
                }
            } catch (\Exception $e) {
                return response($e->getMessage(), 404);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * Force delete user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($user = User::onlyTrashed()->where('name', $request->name)->first()) {
                    $user->notify(new UserForceDeleted());

                    $user->forceDelete();

                    return response(__("The user has been deleted successfully!"));

                } else {
                    return response(__("The user could not be found!"), 404);
                }
            } catch (\Exception $e) {
                return response($e->getMessage(), 404);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $showTrashed = $this->deleted == 'true';

            if ($showTrashed) {
                $users = User::onlyTrashed();
            } else {
                $users = User::select('*');
            }

            if ($this->role) {
                $users = $users->role($this->role);
            }

            if ($this->status) {
                $users = $users->where('status', $this->status);
            }

            $users = $users->get();

            return DataTables::of($users)
                ->editColumn('name', function ($data) {
                    return view('administration.manage_users.partials.datatable.name')
                        ->with(compact('data'));
                })
                ->editColumn('email', function ($data) {
                    return \HTML::mailto($data->email);
                })
                ->addColumn('role', function ($data) {
                    return displayUserRoles($data->getRoleNames());
                })
                ->editColumn('status', function ($data) {
                    return ucfirst($data->status);
                })
                ->addColumn('action', function ($data) use ($showTrashed) {
                    return view('administration.manage_users.partials.datatable.action')
                        ->with(compact('data', 'showTrashed'));
                })
                ->rawColumns(['name', 'role', 'action'])
                ->make(true);
        } else {
            return abort(403);
        }
    }
}
