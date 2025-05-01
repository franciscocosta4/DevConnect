<aside class="w-64 bg-white shadow-md h-full flex flex-col border-r border-gray-200">
    <div class="p-6 flex-1">
        <div class="sidebar-header">
            <h2 class="sidebar-title">Menu</h2>
        </div>
        
        <nav class="sidebar-nav">
            <div class="projects-section">
                <p class="section-label">Seus projetos</p>
                <a href="{{ route('projects.create') }}" class="create-project-btn">
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Criar novo projeto
                </a>
                
                <div class="divider"></div>
                
                <div class="projects-list">
                    @php
                        $projects = Auth::check() ? Auth::user()->projects : null;
                    @endphp
                    
                    @if (!empty($projects))
                        @foreach ($projects as $project)
                            <a href="{{ route('projects.show', $project->slug) }}" class="project-link">
                                <span class="project-badge" style="background-color: {{ $project->visibility == 'public' ? '#38a169' : '#e53e3e' }}"></span>
                                <span class="project-title">{{ $project->title }}</span>
                                @if($project->visibility == 'public')
                                    <svg class="visibility-icon public" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="visibility-icon private" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    @else
                        <p class="empty-message">Nenhum projeto encontrado</p>
                    @endif
                </div>
            </div>
        </nav>
    </div>
    
    <!-- <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>
                <p class="user-email">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div> -->
</aside>

<style>
    /* Sidebar Styles */
.sidebar {
    width: 280px;
    height: 100vh;
    background-color: #ffffff;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.sidebar-content {
    padding: 1.5rem;
    flex: 1;
    overflow-y: auto;
}

.sidebar-header {
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.sidebar-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a365d;
    margin: 0;
}

.section-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
    display: block;
}

.create-project-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    background-color:#1a365d;
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 1.5rem;
    transition: all 0.2s;
}

.create-project-btn:hover {
    background-color: #3182ce;
    transform: translateY(-1px);
}

.btn-icon {
    width: 1.25rem;
    height: 1.25rem;
}

.divider {
    height: 1px;
    background-color: #e2e8f0;
    margin: 1rem 0;
}

.projects-list {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.project-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    color: #4a5568;
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.2s;
    position: relative;
}

.project-link:hover {
    background-color: #f7fafc;
    color: #1a365d;
}

.project-badge {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    flex-shrink: 0;
}

.project-title {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.visibility-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
}

.visibility-icon.public {
    color: #38a169;
}

.visibility-icon.private {
    color: #e53e3e;
}

.empty-message {
    color: #a0aec0;
    font-size: 0.9rem;
    text-align: center;
    padding: 1rem;
}

.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid #e2e8f0;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background-color: #4299e1;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    flex-shrink: 0;
}

.user-info {
    overflow: hidden;
}

.user-name {
    font-size: 0.9rem;
    font-weight: 500;
    color: #1a365d;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-email {
    font-size: 0.75rem;
    color: #718096;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Active state */
.project-link.active {
    background-color: #ebf8ff;
    color: #3182ce;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sidebar {
        width: 240px;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.open {
        transform: translateX(0);
    }
}
</style>