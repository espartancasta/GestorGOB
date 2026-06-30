@extends("frontend.master")

@section("content")

<div class="gob-dashboard">
    @include("frontend.home.inc.sidebar")

    <div class="gob-main">
        @auth
            @if(auth()->user()->role == 1)
                <div class="gob-header">
                    <h2>Inicio</h2>
                    <p>Gestiona y explora proyectos de investigacion aprobados</p>
                </div>

                <details class="gob-projects-dropdown" open>
                    <summary class="gob-projects-summary">
                        <div>
                            <h3>Articulos / proyectos aprobados</h3>
                            <p>Consulta los documentos que ya finalizaron el proceso de revision.</p>
                        </div>
                        <span class="gob-projects-summary-icon"><i class="las la-angle-down"></i></span>
                    </summary>

                    <div class="gob-grid gob-approved-grid">
                        <a href="{{ route('submissions.create') }}" class="gob-card gob-new-project-card">
                            <div class="gob-card-icon"><i class="las la-plus-circle"></i></div>
                            <h4>Nuevo proyecto</h4>
                            <p>Sube un nuevo documento de investigacion para iniciar el flujo de revision.</p>
                            <div class="gob-card-footer">
                                <span>Autor</span>
                                <span>Crear</span>
                            </div>
                        </a>

                        @forelse(($approvedSubmissions ?? collect()) as $submission)
                            <div class="gob-card gob-approved-card">
                                <div class="gob-card-icon"><i class="las la-file-alt"></i></div>
                                <h4>{{ $submission->title }}</h4>
                                <p>{{ \Illuminate\Support\Str::limit($submission->summary, 110) }}</p>
                                <div class="gob-card-footer">
                                    <span>{{ $submission->updated_at ? $submission->updated_at->diffForHumans() : 'Sin fecha' }}</span>
                                    <span class="gob-status-approved">Aprobado</span>
                                </div>
                            </div>
                        @empty
                            <div class="gob-card gob-empty-card">
                                <div class="gob-card-icon"><i class="las la-folder-open"></i></div>
                                <h4>Sin proyectos aprobados</h4>
                                <p>Todavia no hay documentos con estado completado. Cuando un articulo sea aprobado, aparecera en esta seccion.</p>
                                <div class="gob-card-footer">
                                    <span>GestorGOB</span>
                                    <span>En espera</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </details>
            @else
                <div class="gob-header">
                    <h2>Inicio</h2>
                    <p>Gestiona y explora proyectos de investigacion</p>
                </div>

                <div class="gob-grid">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="gob-card">
                            <div class="gob-card-icon"><i class="las la-file-alt"></i></div>
                            <h4>Proyecto de Investigacion {{ $i }}</h4>
                            <p>Descripcion breve del proyecto de investigacion y sus principales hallazgos.</p>
                            <div class="gob-card-footer">
                                <span>3 dias atras</span>
                                <span>4.5</span>
                            </div>
                        </div>
                    @endfor
                </div>
            @endif
        @endauth

        @guest
            <style>
                .public-home { display: grid; gap: 34px; padding-bottom: 42px; color: #111827; }
                .public-hero, .public-process { overflow: hidden; border: 1px solid #ead7df; border-radius: 16px; background: #fff; box-shadow: 0 8px 18px rgba(17,24,39,.08); }
                .public-hero { position: relative; display: grid; grid-template-columns: minmax(0, 1fr) 300px; gap: 38px; align-items: center; padding: 46px 40px; }
                .public-hero::before { content: ""; position: absolute; top: 0; right: 0; left: 0; height: 5px; background: linear-gradient(90deg, #611232 0%, #d4af37 50%, #611232 100%); }
                .public-badge { display: inline-flex; align-items: center; gap: 8px; min-height: 28px; margin-bottom: 18px; padding: 5px 14px; border-radius: 999px; background: #f7edf2; color: #611232 !important; font-size: 13px; font-weight: 900; }
                .public-badge::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: #d4af37; }
                .public-hero h1 { margin: 0 0 14px; color: #111827 !important; font-size: 40px; font-weight: 900 !important; line-height: 1.12; }
                .public-hero h1 span { color: #611232 !important; }
                .public-lead { max-width: 700px; margin: 0 0 12px; color: #475569 !important; font-size: 18px; font-weight: 800; line-height: 1.5; }
                .public-copy { max-width: 720px; margin: 0; color: #7a8699 !important; font-size: 15px; line-height: 1.6; }
                .public-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 34px; }
                .public-btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; min-width: 152px; min-height: 48px; padding: 0 22px; border-radius: 9px; font-weight: 900; text-decoration: none !important; }
                .public-btn-primary { border: 1px solid #611232; background: #611232; color: #fff !important; box-shadow: 0 8px 16px rgba(97,18,50,.24); }
                .public-btn-secondary { border: 2px solid #611232; background: #fff; color: #611232 !important; }
                .public-hero-visual { display: grid; place-items: center; min-height: 226px; border: 1px solid #ead7df; border-radius: 16px; background: #fbf7f8; text-align: center; }
                .public-paper-stack { position: relative; width: 94px; height: 106px; margin: 0 auto 16px; }
                .public-paper-stack::before, .public-paper-stack::after, .public-paper { content: ""; position: absolute; inset: 0; border-radius: 8px; background: #fff; box-shadow: 0 8px 18px rgba(17,24,39,.18); }
                .public-paper-stack::before { transform: rotate(-8deg) translate(-5px, 7px); opacity: .75; }
                .public-paper-stack::after { transform: rotate(5deg) translate(6px, 4px); opacity: .85; }
                .public-paper { z-index: 2; border-top: 7px solid #611232; }
                .public-paper span { display: block; height: 7px; margin: 15px 13px 0; border-radius: 999px; background: #e5e7eb; }
                .public-visual-icon { display: inline-flex; align-items: center; justify-content: center; color: #611232 !important; font-size: 36px; }
                .public-hero-visual strong { display: block; margin-top: 6px; color: #611232; font-size: 13px; font-weight: 900; }
                .public-section-head { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 18px; }
                .public-section-title { display: flex; align-items: center; gap: 10px; margin: 0; color: #111827 !important; font-size: 22px; font-weight: 900 !important; }
                .public-section-title::before { content: ""; width: 4px; height: 22px; border-radius: 999px; background: #d4af37; }
                .public-see-all { color: #611232 !important; font-weight: 900; text-decoration: none !important; }
                .public-quick-grid, .public-calls-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
                .public-quick-card, .public-call-card { border: 1px solid #eef0f4; border-radius: 14px; background: #fff; box-shadow: 0 7px 16px rgba(17,24,39,.08); }
                .public-quick-card { padding: 24px; }
                .public-icon-soft { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin-bottom: 16px; border-radius: 10px; background: #f3eaf0; color: #611232 !important; font-size: 23px; }
                .public-quick-card h3, .public-call-card h3 { margin: 0 0 10px; color: #111827 !important; font-size: 16px; font-weight: 900 !important; line-height: 1.35; }
                .public-quick-card p, .public-call-card p, .public-step p { margin: 0; color: #718096 !important; font-size: 14px; line-height: 1.55; }
                .public-link { display: inline-flex; align-items: center; gap: 6px; margin-top: 18px; color: #611232 !important; font-size: 13px; font-weight: 900; text-decoration: none !important; }
                .public-call-card { position: relative; overflow: hidden; padding: 24px; }
                .public-call-card::before { content: ""; position: absolute; top: 0; right: 0; left: 0; height: 4px; background: linear-gradient(90deg, #611232 0%, #d4af37 100%); }
                .public-call-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
                .public-call-category, .public-call-status { display: inline-flex; align-items: center; min-height: 24px; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 900; }
                .public-call-category { border-radius: 6px; background: #fff7dd; color: #946800 !important; }
                .public-call-status { background: #dcfce7; color: #047857 !important; }
                .public-call-status.is-soon { background: #fff7dd; color: #c2410c !important; }
                .public-call-date { display: flex; align-items: center; gap: 7px; margin: 18px 0; color: #8b97aa !important; font-size: 13px; }
                .public-call-btn { display: inline-flex; align-items: center; justify-content: center; width: 100%; min-height: 36px; border: 1px solid #611232; border-radius: 8px; color: #611232 !important; font-size: 13px; font-weight: 900; text-decoration: none !important; }
                .public-process { padding: 34px 40px; }
                .public-steps { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 34px 72px; margin: 30px 0 32px; text-align: center; }
                .public-step-icon { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; margin-bottom: 14px; border: 3px solid #fff; border-radius: 50%; background: #611232; color: #fff !important; font-size: 26px; box-shadow: 0 8px 18px rgba(97,18,50,.22); }
                .public-step small { display: block; margin-bottom: 5px; color: #d4a617 !important; font-size: 13px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }
                .public-step h3 { margin: 0 0 9px; color: #111827 !important; font-size: 16px; font-weight: 900 !important; }
                .public-process-action { text-align: center; }
                @media (max-width: 980px) {
                    .public-hero, .public-quick-grid, .public-calls-grid, .public-steps { grid-template-columns: 1fr; }
                    .public-hero { padding: 34px 24px; }
                    .public-hero h1 { font-size: 32px; }
                }
            </style>

            <section class="public-home">
                <article class="public-hero">
                    <div>
                        <span class="public-badge">Sistema oficial del Gobierno de Mexico</span>
                        <h1>Bienvenido</h1>
                        <p class="public-lead">Sistema de gestion documental para el registro, seguimiento y evaluacion de propuestas de investigacion.</p>
                        <p class="public-copy">Consulta convocatorias, registra nuevas propuestas y da seguimiento al proceso editorial de tus documentos de forma segura e institucional.</p>
                        <div class="public-actions">
                            <a href="{{ route('auth.signup') }}" class="public-btn public-btn-primary"><i class="las la-user-plus"></i> Crear cuenta</a>
                            <a href="{{ route('auth.login') }}" class="public-btn public-btn-secondary">Iniciar sesion <i class="las la-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="public-hero-visual">
                        <div>
                            <div class="public-paper-stack"><div class="public-paper"><span></span><span></span><span></span></div></div>
                            <span class="public-visual-icon"><i class="las la-file-alt"></i></span>
                            <strong>Gestion documental</strong>
                        </div>
                    </div>
                </article>

                <section>
                    <div class="public-section-head"><h2 class="public-section-title">Accesos rapidos</h2></div>
                    <div class="public-quick-grid">
                        <article class="public-quick-card">
                            <span class="public-icon-soft"><i class="las la-book-open"></i></span>
                            <h3>Convocatorias disponibles</h3>
                            <p>Consulta las convocatorias activas para registrar propuestas de investigacion.</p>
                            <a href="#convocatorias-destacadas" class="public-link">Ver mas <i class="las la-angle-right"></i></a>
                        </article>
                        <article class="public-quick-card">
                            <span class="public-icon-soft"><i class="las la-clipboard-list"></i></span>
                            <h3>Seguimiento documental</h3>
                            <p>Da seguimiento al estado de evaluacion de tus documentos en tiempo real.</p>
                            <a href="{{ route('auth.login') }}" class="public-link">Ver mas <i class="las la-angle-right"></i></a>
                        </article>
                        <article class="public-quick-card">
                            <span class="public-icon-soft"><i class="las la-comment"></i></span>
                            <h3>Comunicacion interna</h3>
                            <p>Manten contacto con revisores y responsables mediante chats de seguimiento.</p>
                            <a href="{{ route('auth.login') }}" class="public-link">Ver mas <i class="las la-angle-right"></i></a>
                        </article>
                    </div>
                </section>

                <section id="convocatorias-destacadas">
                    <div class="public-section-head">
                        <h2 class="public-section-title">Convocatorias destacadas</h2>
                        <a href="#convocatorias-destacadas" class="public-see-all">Ver todas <i class="las la-external-link-alt"></i></a>
                    </div>
                    <div class="public-calls-grid">
                        @foreach(($featuredCalls ?? []) as $call)
                            <article class="public-call-card">
                                <div class="public-call-top">
                                    <span class="public-icon-soft"><i class="las la-file-alt"></i></span>
                                    <span class="public-call-status {{ $call['status'] === 'Proximamente' ? 'is-soon' : '' }}">{{ $call['status'] }}</span>
                                </div>
                                <span class="public-call-category">{{ $call['category'] }}</span>
                                <h3>{{ $call['title'] }}</h3>
                                <p>{{ $call['description'] }}</p>
                                <div class="public-call-date"><i class="las la-calendar"></i> Disponible hasta {{ $call['deadline'] }}</div>
                                <a href="#convocatorias-destacadas" class="public-call-btn">Ver convocatoria</a>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="public-process">
                    <h2 class="public-section-title">Proceso de participacion</h2>
                    <div class="public-steps">
                        <article class="public-step"><span class="public-step-icon"><i class="las la-user-plus"></i></span><small>Paso 1</small><h3>Crear cuenta</h3><p>Registrate con tus datos institucionales y crea tu perfil de usuario.</p></article>
                        <article class="public-step"><span class="public-step-icon"><i class="las la-clipboard-list"></i></span><small>Paso 2</small><h3>Registrar propuesta</h3><p>Completa el formulario de tu propuesta y adjunta los documentos requeridos.</p></article>
                        <article class="public-step"><span class="public-step-icon"><i class="las la-users"></i></span><small>Paso 3</small><h3>Evaluacion por revisores</h3><p>Tu propuesta es asignada a revisores expertos para su analisis y retroalimentacion.</p></article>
                        <article class="public-step"><span class="public-step-icon"><i class="las la-award"></i></span><small>Paso 4</small><h3>Revision completada</h3><p>Recibe el dictamen final y accede al historial de tu proceso editorial.</p></article>
                    </div>
                    <div class="public-process-action">
                        <a href="{{ route('auth.signup') }}" class="public-btn public-btn-primary"><i class="las la-user-plus"></i> Comenzar ahora &mdash; es gratis</a>
                    </div>
                </section>
            </section>
        @endguest
    </div>
</div>

@endsection
