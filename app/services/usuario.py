from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from app.db.models.usuario import Usuario
from app.schemas.usuario import UsuarioCreate
from app.core.security import hash_password

async def get_usuarios(db: AsyncSession):
    result = await db.execute(select(Usuario))
    return result.scalars().all()

async def create_usuario(db: AsyncSession, data: UsuarioCreate):
    hashed = hash_password(data.contrasena)
    usuario = Usuario(
        username=data.username,
        contrasena_hash=hashed,
        empleado_id=data.empleado_id,
        rol_id=data.rol_id
    )
    db.add(usuario)
    await db.commit()
    await db.refresh(usuario)
    return usuario