from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from app.db.models.vehiculo_sucursal import VehiculoSucursal
from app.schemas.vehiculo_sucursal import VehiculoSucursalCreate

async def get_relaciones(db: AsyncSession):
    result = await db.execute(select(VehiculoSucursal))
    return result.scalars().all()

async def create_relacion(db: AsyncSession, data: VehiculoSucursalCreate):
    relacion = VehiculoSucursal(**data.dict())
    db.add(relacion)
    await db.commit()
    await db.refresh(relacion)
    return relacion